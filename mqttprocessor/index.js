const Sequelize = require('sequelize');
const mqtt = require('mqtt');
const config = require('config');
const moment = require('moment');

var client = mqtt.connect(config.get('pharmcle.mqtt.host'))

const sequelize =
  new Sequelize(
    config.get('pharmcle.dbConfig.dbName'),
    config.get('pharmcle.dbConfig.user'),
    config.get('pharmcle.dbConfig.pass'), {
      host: config.get('pharmcle.dbConfig.host'),
      dialect: config.get('pharmcle.dbConfig.dialect'),
      operatorsAliases: false,
      logging: console.log,
      pool: {
        max: 5,
        min: 0,
        acquire: 30000,
        idle: 10000
      },
      define: {
        timestamps: false
      }
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

    if (appID != 1 || appID != 3) {

      if (signalType === 'rx') {
        origin = JSON.parse(message.toString());
        // process special Ack ( interval, on/off )

        switch (origin.fPort) {
          case 18:
            console.log(origin.data)
            converted = decodeSpecialAck(origin.devEUI, origin);
            origin.data = converted
            console.log('@@@@@@ START OF Interval/Schedule SET!!! @@@@@@');
            console.log(origin)
            console.log('@@@@@@ END OF Interval/Schedule SET!!! @@@@@@');
            updateSpecialAck(origin)
            break;

          case 19:
            createLogData(origin);
            updateLastStatus(origin);
            console.log(origin.devEUI);
            console.log(origin.deviceName);
            console.log(origin.rxInfo[0]['time']);
            break;
            // default:
        }
        // if (origin.fPort === 18) {
        //   console.log(origin.data)
        //   converted = decodeSpecialAck(origin.devEUI, origin);
        //   origin.data = converted
        //   console.log('@@@@@@ START OF Interval/Schedule SET!!! @@@@@@');
        //   console.log(origin)
        //   console.log('@@@@@@ END OF Interval/Schedule SET!!! @@@@@@');
        //   updateSpecialAck(origin)
        //
        // } else if (origin.fPort === 19) {
        //   if (origin.object.digitalOutput[0] === 1 || origin.object.digitalOutput[0] === 0) {
        //     createLogData(origin);
        //     updateLastStatus(origin);
        //     console.log(origin.devEUI);
        //     console.log(origin.deviceName);
        //     console.log(origin.rxInfo[0]['time']);
        //   }

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
  // }
})

decodeSpecialAck = (devEUI, msg) => {

  buf = new Buffer(msg.data, 'base64');
  let interval = buf.readUInt8(0)
  let date_on = moment.unix(buf.readUInt32BE(1)).format('YYYY-MM-DD')
  let date_off = moment.unix(buf.readUInt32BE(5)).format('YYYY-MM-DD')
  let time_on = moment.unix(buf.readUInt32BE(1)).format('HH')
  let time_off = moment.unix(buf.readUInt32BE(5)).format('HH')
  let dev_time = moment.unix(buf.readUInt32BE(9)).format('YYYY-MM-DD HH:mm:ss')
  data = {
    interval: interval,
    dateOn: date_on,
    dateOff: date_off,
    timeOn: time_on,
    timeOff: time_off,
    devTime: dev_time
  };

  NodeControlLog.create({
    nodeNum: devEUI,
    signalType: 'RX',
    interval: interval,
    dateOn: date_on,
    dateOff: date_off,
    timeOn: time_on,
    timeOff: time_off,
    devTime: dev_time
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
  if (header.applicationID === "7") {
    let sentDate = moment(header.rxInfo[0]['time']).format('YYYY-MM-DD HH:mm:ss')
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
      temperature: header.object.temperatureSensor[0],
      humidity: header.object.humiditySensor[0],
      currents: Math.abs(header.object.analogInput[1]),
      currents2: Math.abs(header.object.analogInput[2]),
      currents3: Math.abs(header.object.analogInput[3]),
      relay: header.object.digitalOutput[0],
      sentDate: sentDate,
      // receiveDate: new Date()
      receiveDate: receiveDate
    })
  } else {
    let sentDate = moment(header.rxInfo[0]['time']).format('YYYY-MM-DD HH:mm:ss')
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
      temperature: header.object.temperatureSensor[0],
      humidity: header.object.humiditySensor[0],
      currents: Math.abs(header.object.analogInput[1]) * 100,
      currents2: Math.abs(header.object.analogInput[2]),
      currents3: Math.abs(header.object.analogInput[3]),
      relay: header.object.digitalOutput[0],
      sentDate: sentDate,
      // receiveDate: new Date()
      receiveDate: receiveDate
    })
  }
};

updateLastStatus = (header) => {
  let nodeName = header.nodeName ? header.nodeName : header.deviceName;
  if (header.applicationID === "7") {
    let sentDate = moment(header.rxInfo[0]['time']).format('YYYY-MM-DD HH:mm:ss')
    let receiveDate = moment()
    NodeList.update({
      node_name: nodeName,
      temperature: header.object.temperatureSensor[0],
      humidity: header.object.humiditySensor[0],
      current: Math.abs(header.object.analogInput[1]),
      current2: Math.abs(header.object.analogInput[2]),
      current3: Math.abs(header.object.analogInput[3]),
      relay: header.object.digitalOutput[0],
      sentDate: sentDate,
      // receiveDate: new Date(),
      receiveDate: receiveDate
    }, {
      where: {
        serial: header.devEUI
      }
    })
  } else {
    let sentDate = moment(header.rxInfo[0]['time']).format('YYYY-MM-DD HH:mm:ss')
    let receiveDate = moment()
    NodeList.update({
      node_name: nodeName,
      temperature: header.object.temperatureSensor[0],
      humidity: header.object.humiditySensor[0],
      current: Math.abs(header.object.analogInput[1]) * 100,
      current2: Math.abs(header.object.analogInput[2]),
      current3: Math.abs(header.object.analogInput[3]),
      relay: header.object.digitalOutput[0],
      sentDate: sentDate,
      // receiveDate: new Date(),
      receiveDate: receiveDate
    }, {
      where: {
        serial: header.devEUI
      }
    })
  }
};

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
