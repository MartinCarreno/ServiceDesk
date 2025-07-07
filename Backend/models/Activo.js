const { DataTypes } = require('sequelize');
const sequelize = require('../config/database');
const Usuario = require('./Usuario'); // Para el FK de id_usuario_resp

const Activo = sequelize.define('Activo', {
    id_activo: {
        type: DataTypes.BIGINT,
        primaryKey: true,
        autoIncrement: true,
    },
    serial_activo: {
        type: DataTypes.STRING(100),
        allowNull: false,
    },
    marca_activo: {
        type: DataTypes.STRING(100),
        allowNull: false,
    },
    modelo_activo: {
        type: DataTypes.STRING(100),
        allowNull: false,
    },
    cate_activo: {
        type: DataTypes.STRING(100),
        allowNull: false,
    },
    subcate_activo: {
        type: DataTypes.STRING(100),
        allowNull: false,
    },
    fec_compra: {
        type: DataTypes.DATE,
        allowNull: false,
    },
    estado_activo: {
        type: DataTypes.ENUM('operativo', 'obsoleto'),
        allowNull: false,
    },
    ubica_activo: {
        type: DataTypes.STRING(100),
        allowNull: false,
    },
}, {
    tableName: 'activos',
    timestamps: false,
});

Activo.belongsTo(Usuario, { foreignKey: 'id_usuario_resp', targetKey: 'id_usuario' });

module.exports = Activo;
