/* jshint indent: 2 */

module.exports = function(sequelize, DataTypes) {
  return sequelize.define('node_list', {
    node_name: {
      type: DataTypes.STRING(255),
      allowNull: false
    },
    serial: {
      type: DataTypes.STRING(100),
      allowNull: false,
    },
    division: {
      type: DataTypes.STRING(100),
      allowNull: true,
    },
    type: {
      type: DataTypes.STRING(255),
      allowNull: true,
    },
    site_name: {
      type: DataTypes.INTEGER(11),
      defaultValue: '',
      allowNull: true
    },
    channel: {
      type: DataTypes.INTEGER(11),
      allowNull: false
    },
    manage_num: {
      type: DataTypes.STRING(255),
      allowNull: true,
    },
    set_date: {
      type: DataTypes.DATE,
      allowNull: true,
    },
    set_place: {
      type: DataTypes.STRING(255),
      allowNull: true,
    },
    street_lamp: {
      type: DataTypes.STRING(255),
      allowNull: true,
    },
    latitude: {
      type: "DOUBLE",
      allowNull: true,
    },
    longitude: {
      type: "DOUBLE",
      allowNull: true,
    },
    use: {
      type: DataTypes.INTEGER(11),
      allowNull: true,
      defaultValue: '1'
    },
    temperature: {
      type: DataTypes.FLOAT,
      allowNull: true,
    },
    humidity: {
      type: DataTypes.FLOAT,
      allowNull: true,
    },
    standard: {
      type: DataTypes.FLOAT,
      allowNull: true,
      defaultValue: '200'
    },
    current: {
      type: DataTypes.FLOAT,
      allowNull: true,
    },
    current2: {
      type: DataTypes.FLOAT,
      allowNull: true,

    },
    current3: {
      type: DataTypes.FLOAT,
      allowNull: true,
    },
    relay: {
      type: DataTypes.INTEGER(1),
      allowNull: true,
      defaultValue: '0'
    },
    sentDate: {
      type: DataTypes.DATE,
      allowNull: true,
    },
    receiveDate: {
      type: DataTypes.DATE,
      allowNull: true,
    },
    interval: {
      type: DataTypes.INTEGER(11),
      allowNull: true,
    },
    dateOn: {
      type: DataTypes.STRING(10),
      allowNull: true,
    },
    dateOff: {
      type: DataTypes.STRING(10),
      allowNull: true,
    },
    timeOn: {
      type: DataTypes.STRING(8),
      allowNull: true,
    },
    timeOff: {
      type: DataTypes.STRING(8),
      allowNull: true,
    },
    controlAt: {
      type: DataTypes.DATE,
      allowNull: true,
    },
    createdAt: {
      allowNull: false,
      type: DataTypes.DATE,
    },
    updatedAt: {
      allowNull: false,
      type: DataTypes.DATE
    }
  }, {
    tableName: 'node_list'
  });
};
