const Sequelize = require('sequelize');
const mqtt = require('mqtt');
const config = require('config');
const moment = require('moment');
const Op = Sequelize.Op;

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
var node = []
NodeList.findAll({
  where:{ receiveDate: { [Op.ne]: null } },
  order: [
    ['createdAt', 'DESC']
  ]
}).then(result => {
  var query = '';
  node = []
  for(var i=0; i<result.length; i++){
    // node[i] = result[i].node_name;
    query = `SELECT nodeName, AVG(currents) as avgcur FROM (SELECT * FROM node_receivelog WHERE nodeName='${result[i].node_name}' AND currents > 100 ORDER BY sentDate asc LIMIT 100) T GROUP BY nodeName;`;
    NodeReceiveLog.sequelize.query(query).spread(function(results, metadata) {
      console.log(results);
      if(results.length > 0){
        console.log("result------"+(results[0,[0]].avgcur));
        NodeList.update({
          standard: results[0,[0]].avgcur,
        }, {
          where: {
            node_name: results[0,[0]].nodeName
          }
        })

      }else{
      console.log("result------");
      }
    }, function(err) {
      console.log(err)
    });
  }
});
