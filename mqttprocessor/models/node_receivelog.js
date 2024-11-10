/* jshint indent: 2 */

module.exports = function(sequelize, DataTypes) {
  return sequelize.define('node_receivelog', {
    id: {
      type: DataTypes.INTEGER(11),
      allowNull: false,
      primaryKey: true,
      autoIncrement: true
    },
    devEUI: {
      type: DataTypes.STRING(255),
      allowNull: false
    },
    nodeName: {
      type: DataTypes.STRING(255),
      allowNull: true
    },
    applicationID: {
      type: DataTypes.STRING(10),
      allowNull: false
    },
    applicationName: {
      type: DataTypes.STRING(255),
      allowNull: false
    },
    gwName: {
      type: DataTypes.STRING(50),
      allowNull: false
    },
    rssi: {
      type: DataTypes.INTEGER(11),
      allowNull: false,
      defaultValue: '0'
    },
    loraSNR: {
      type: DataTypes.FLOAT,
      allowNull: false,
      defaultValue: '0'
    },
    frequency: {
      type: DataTypes.INTEGER(11),
      allowNull: false,
      defaultValue: '0'
    },
    fCnt: {
      type: DataTypes.INTEGER(11),
      allowNull: false,
      defaultValue: '0'
    },
    fPort: {
      type: DataTypes.INTEGER(11),
      allowNull: false,
      defaultValue: '0'
    },
    temperature: {
      type: DataTypes.FLOAT,
      allowNull: false,
      defaultValue: '0'
    },
    humidity: {
      type: DataTypes.FLOAT,
      allowNull: false,
      defaultValue: '0'
    },
    currents: {
      type: DataTypes.FLOAT,
      allowNull: false,
      defaultValue: '0'
    },

    currents2: {
      type: DataTypes.FLOAT,
      allowNull: true,
      defaultValue: '0'
    },
    currents3: {
      type: DataTypes.FLOAT,
      allowNull: true,
      defaultValue: '0'
    },
    relay: {
      type: DataTypes.INTEGER(11),
      allowNull: false,
      defaultValue: '0'
    },
    sentDate: {
      type: DataTypes.DATE,
      allowNull: false
    },
    receiveDate: {
      type: DataTypes.DATE,
      allowNull: false
    }
  }, {
    tableName: 'node_receivelog',
  });
};
