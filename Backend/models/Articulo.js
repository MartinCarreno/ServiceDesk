const { DataTypes } = require('sequelize');
const sequelize = require('../config/database');
const Usuario = require('./Usuario'); // Para el FK de id_tecnico_creador

const Articulo = sequelize.define('Articulo', {
     id_articulo: {
      type: DataTypes.BIGINT,
      primaryKey: true,
      autoIncrement: true
    },
    titulo_articulo: {
      type: DataTypes.STRING(100),
      allowNull: false
    },
    conten_articulo: {
      type: DataTypes.TEXT,
      allowNull: false
    },
    cate_articulo: {
      type: DataTypes.STRING(100),
      allowNull: false
    },
    subcate_articulo: {
      type: DataTypes.STRING(100),
      allowNull: false
    },
    fecha_creacion: {
      type: DataTypes.DATE,
      defaultValue: DataTypes.NOW
    },
    visibilidad: {
      type: DataTypes.ENUM('agente', 'publico'),
      defaultValue: 'publico'
    },
    estado_publicacion: {
      type: DataTypes.BOOLEAN,
      defaultValue: true
    },
    url_documento: {
      type: DataTypes.TEXT,
      allowNull: true
    },
    imagen_articulo: {
      type: DataTypes.TEXT,
      allowNull: true
    },
    id_tecnico_creador: {
      type: DataTypes.BIGINT,
      allowNull: true,
      references: {
        model: 'usuarios',
        key: 'id_usuario'
      }
    }
  }, {
    tableName: 'articulos',
    timestamps: false
  });

  Articulo.associate = function(models) {
    Articulo.belongsTo(models.Usuario, {
      foreignKey: 'id_tecnico_creador',
      as: 'tecnicoCreador'
    });
  };

  module.exports = Articulo;