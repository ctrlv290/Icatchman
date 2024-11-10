const Sequelize = require('sequelize');
const mqtt = require('mqtt');
const config = require('config');

var moment = require('moment');

var client = mqtt.connect(config.get('pharmcle.mqtt.host'))

const sequelize =
  new Sequelize(
    config.get('pharmcle.dbConfig.dbName'),
    config.get('pharmcle.dbConfig.user'),
    config.get('pharmcle.dbConfig.pass'), {

      host: config.get('pharmcle.dbConfig.host'),
      dialect: config.get('pharmcle.dbConfig.dialect'),
      operatorsAliases: false,
      pool: {
        max: 5,
        min: 0,
        acquire: 30000,
        idle: 10000
      },
      define: {
        timestamps: false
      },
    });

sequelize
  .authenticate()
  .then(() => {
    console.log('Connection has been established successfully.');
  })
  .catch(err => {
    console.error('Unable to connect to the database:', err);
  });

const NodeReceiveLog = sequelize.import(__dirname + "/models/node_receivelog")
const NodeList = sequelize.import(__dirname + "/models/node_list")
const NodeControlLog = sequelize.import(__dirname + "/models/node_control_log")


client.on('connect', function() {
  client.subscribe([config.get('pharmcle.mqtt.sub_prefix') + '/+/node/+/rx', config.get('pharmcle.mqtt.pub_prefix') + '/+/node/+/tx']);
})

client.on('message', function(topic, message) {
  // message is Buffer
  let parseTopic = /([a-zA-Z0-9]*)\/([0-9]*)\/node\/([\w]*)\/(tx|rx)$/.exec(topic);


  if (parseTopic !== null) {
    let appChannel = parseTopic[1]
    let appID = parseTopic[2]
    let deviceID = parseTopic[3]
    let signalType = parseTopic[4]

    //  console.log(message.payload.toString());;
    //        if(topic.endsWith("/rx")){
    if (appID == 1 || appID == 3) {

      if (signalType === 'rx') {
        origin = JSON.parse(message.toString());
        // process special Ack ( interval, on/off )
        if (origin.fPort === 98) {
          converted = decodeSpecialAck(origin.devEUI, origin);
          origin.data = converted
          console.log('@@@@@@ START OF Interval/Schedule SET!!! @@@@@@');
          console.log(origin)
          console.log('@@@@@@ END OF Interval/Schedule SET!!! @@@@@@');
          updateSpecialAck(origin)

        } else if (origin.fPort === 99) {
          converted = decodeFromData(origin.data);
          origin.data = converted;
          if (origin.data.relay === 1 || origin.data.relay === 0) {
            createLogData(origin);
            updateLastStatus(origin)

            // console.log(origin);
            client.publish(config.get('pharmcle.mqtt.decode_prefix') + `/${appID}/node/` + origin.devEUI + '/rx', JSON.stringify(origin));

            // check current device time and fix if difference with server time is more than 10min.

            //             console.log(moment().format('YYYY-MM-DD HH:mm:ss'))
            //             console.log(moment().local().format('YYYY-MM-DD HH:mm:ss'))
            //             console.log('@@@@@@@@' + appID);
            //             console.log(origin.data.sentDate)
            //console.log(Math.abs(moment().diff(origin.data.sentDate,'minutes')))
            // if(Promise.resolve(checkLastControlTime(origin.devEUI))) {console.log('@@@TRUE')} else {console.log('@@@@FALSE')}
            // updateControlDataForAdjustTime(origin.devEUI)
            // 5/7 if문 추가 appID === 1
            if (`${appID}` === 1) {
              if (Math.abs(moment().diff(origin.data.sentDate, 'minutes')) > config.get('pharmcle.time_adjust_condition')) {

                //check last control time to see if good to go
                //this is needed to avoid recurring downlink ( device is programmed to send back immediately when downlink)
                if (Promise.resolve(checkLastControlTime(origin.devEUI))) {
                  //convert current timestamp to hex and then base64
                  let timedata = new Buffer(moment().unix().toString(16), 'hex').toString('base64')
                  client.publish(config.get('pharmcle.mqtt.pub_prefix') +
                    `/${appID}/node/${origin.devEUI}/tx`,
                    `{
									"confirmed": false,
									"data": "${timedata}",
									"devEUI": "${origin.devEUI}",
									"fPort": 94,
									"reference": "string"}`);

                  // update controlAt in NodeData table
                  updateControlDataForAdjustTime(origin.devEUI)
                }
              }
            }
          }
        }
        //        } else if (topic.endsWith("/tx")) {
      } else if (signalType === 'tx') {
        origin = JSON.parse(message.toString());
        decodeDownLink(origin);
        // deviceID = /application\/1\/node\/([\w]*)\/tx$/.exec(topic)
        console.log(`downlink to : ${appChannel} ${appID} ${deviceID}`)
        // console.log(deviceID[1])
        console.log(origin)
        //createDownLinkLog();
        //updateLastDownLinkData();
      } else {

      }
    }
  }
})

decodeFromData = (msg) => {

  buf = new Buffer(msg, 'base64');

  // var sentDate = moment.unix(buf.readUInt32BE(5)).format('YYYY-MM-DD HH:mm:00').toString();
  let sentDate = moment.unix(buf.readUInt32BE(5)).format('YYYY-MM-DD HH:mm:ss');
  return data = {
    // temperature:buf.readInt16BE(2)*0.1,
    // humidity:buf.readUInt8(6)*0.5,
    // currents: buf.readUInt16BE(9),
    // relay: buf.readUInt8(13)
    temperature: buf.readInt8(0),
    humidity: buf.readUInt8(1),
    currents: buf.readUInt16BE(2) * 0.01,
    relay: buf.readUInt8(4),
    sentDate: sentDate
  };
}

decodeSpecialAck = (devEUI, msg) => {

  buf = new Buffer(msg.data, 'base64');
  let interval = buf.readUInt8(0)
  let date_on = moment.unix(buf.readUInt32BE(1)).format('YYYY-MM-DD')
  let date_off = moment.unix(buf.readUInt32BE(5)).format('YYYY-MM-DD')
  let time_on = moment.unix(buf.readUInt32BE(1)).format('HH')
  let time_off = moment.unix(buf.readUInt32BE(5)).format('HH')
  //5/24 함수 수정 98port 분리
  data = {
    interval: interval,
    dateOn: date_on,
    dateOff: date_off,
    timeOn: time_on,
    timeOff: time_off,
  };
  NodeControlLog.create({
    nodeNum: devEUI,
    signalType: 'RX',
    interval: interval,
    dateOn: date_on,
    dateOff: date_off,
    timeOn: time_on,
    timeOff: time_off
  })
  return data
}

decodeDownLink = (msg) => {

  buf = new Buffer(msg.data, 'base64');

  let switchVal
  let interval
  let date_on
  let date_off
  let time_on
  let time_off
  if (msg.fPort === 96) {
    switchVal = buf.readUInt8(0)
  } else if (msg.fPort === 95) {
    date_on = moment.unix(buf.readUInt32BE(0)).format('YYYY-MM-DD')
    date_off = moment.unix(buf.readUInt32BE(4)).format('YYYY-MM-DD')
    time_on = moment.unix(buf.readUInt32BE(0)).format('HH')
    time_off = moment.unix(buf.readUInt32BE(4)).format('HH')
  } else {}
  NodeControlLog.create({
    nodeNum: msg.devEUI,
    signalType: 'TX',
    instantSwitch: switchVal,
    interval: interval,
    dateOn: date_on,
    dateOff: date_off,
    timeOn: time_on,
    timeOff: time_off
  })
}
createLogData = (header) => {
  let nodeName = header.nodeName ? header.nodeName : header.deviceName;
  let receiveDate = moment()
  NodeReceiveLog.create({
    devEUI: header.devEUI,
    nodeName: nodeName,
    applicationID: header.applicationID,
    applicationName: header.applicationName,
    gwName: header.rxInfo[0]['name'],
    rssi: header.rxInfo[0]['rssi'],
    loraSNR: header.rxInfo[0]['loraSNR'],
    frequency: header.txInfo.frequency,
    fCnt: header.fCnt,
    fPort: header.fPort,
    temperature: header.data.temperature,
    humidity: header.data.humidity,
    currents: header.data.currents,
    relay: header.data.relay,
    sentDate: header.data.sentDate,
    // receiveDate: new Date()
    receiveDate: receiveDate
  });
}

updateLastStatus = (header) => {
  let nodeName = header.nodeName ? header.nodeName : header.deviceName;
  NodeList.update({
    node_name: nodeName,
    temperature: header.data.temperature,
    humidity: header.data.humidity,
    current: header.data.currents,
    relay: header.data.relay,
    sentDate: header.data.sentDate,
    // receiveDate: new Date(),
    receiveDate: moment()
  }, {
    where: {
      serial: header.devEUI
    }
  })
}

updateSpecialAck = (header) => {
  let nodeName = header.nodeName ? header.nodeName : header.deviceName;

  NodeList.update({
    interval: header.data.interval,
    dateOn: header.data.dateOn,
    dateOff: header.data.dateOff,
    timeOn: header.data.timeOn,
    timeOff: header.data.timeOff,
    // receiveDate: new Date(),
    receiveDate: moment()
  }, {
    where: {
      serial: header.devEUI
    }
  })
}

createControlLog = (header) => {
  NodeControlLog.create({
    nodeNum: header.devEUI,
    instantSwitch: header.data.instantSwitch,
    interval: header.data.interval,
    dateOn: header.data.dateOn,
    dateOff: header.data.dateOff,
    timeOn: header.data.timeOn,
    timeOff: header.data.timeOff,
    createdAt: moment()
  })
}

updateControlDataForAdjustTime = (node_num) => {
  NodeList.update({
    controlAt: moment()
  }, {
    where: {
      serial: node_num
    }
  })
}

checkLastControlTime = (node_num) => {
  NodeList.findOne({
    where: {
      serial: node_num
    }
  }).then(node_data => {
    let controltime = moment(!node_data.controlAt ? '1999-01-01 01:01:01' : node_data.controlAt).local().unix();
    controltime = isNaN(controltime) ? 0 : controltime;
    let currenttime = moment().unix()
    // console.log(controltime)
    // console.log(currenttime)
    // console.log(currenttime-controltime)
    return (currenttime - controltime) >= config.get('pharmcle.interval_limit');
  })

};
