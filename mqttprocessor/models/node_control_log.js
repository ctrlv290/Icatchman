/* jshint indent: 2 */

module.exports = function(sequelize, DataTypes) {
  return sequelize.define('nodeControlLog', {
    idx: {
      type: DataTypes.INTEGER(11),
      allowNull: false,
      primaryKey: true,
      autoIncrement: true,
      field: 'idx'
    },
    nodeNum: {
      type: DataTypes.STRING(255),
      allowNull: false,
      field: 'node_num'
    },
    signalType: {
      type: DataTypes.STRING(2),
      allowNull: false,
      field: 'signal_type'
    },
    instantSwitch: {
      type: DataTypes.INTEGER(11),
      allowNull: true,
      field: 'instant_switch'
    },
    interval: {
      type: DataTypes.INTEGER(11),
      allowNull: true,
      field: 'interval'
    },
    dateOn: {
      type: DataTypes.STRING(10),
      allowNull: true,
      field: 'date_on'
    },
    dateOff: {
      type: DataTypes.STRING(10),
      allowNull: true,
      field: 'date_off'
    },
    timeOn: {
      type: DataTypes.STRING(8),
      allowNull: true,
      field: 'time_on'
    },
    timeOff: {
      type: DataTypes.STRING(8),
      allowNull: true,
      field: 'time_off'
    },
    devTime: {
      type: DataTypes.DATE,
      allowNull: true,
      field: 'dev_time'
    },
    createdAt: {
      type: DataTypes.DATE,
      allowNull: true,
      field: 'created_at'
    }
  }, {
    tableName: 'node_control_log'
  });
};
