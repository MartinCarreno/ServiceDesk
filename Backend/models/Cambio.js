const { DataTypes } = require('sequelize');
const sequelize = require('../config/database');
const Usuario = require('./Usuario'); // Para el FK de id_tecnico

const Cambio = sequelize.define('Cambio', {
    id_cambio: {
        type: DataTypes.BIGINT,
        primaryKey: true,
        autoIncrement: true,
    },
    titulo_cambio: {
        type: DataTypes.STRING(200),
        allowNull: false,
    },
    desc_cambio: {
        type: DataTypes.TEXT,
        allowNull: false,
    },
    tipo_cambio: {
        type: DataTypes.STRING(50),
        allowNull: false,
    },
    fecha_cambio: {
        type: DataTypes.DATE,
        allowNull: false,
    },
    riesgo_cambio: {
        type: DataTypes.STRING(50),
        allowNull: false,
    },
    estado_cambio: {
        type: DataTypes.STRING(50),
        allowNull: false,
    },
    id_servicio: { // Nuevo campo
        type: DataTypes.BIGINT,
        allowNull: false,
        references: {
            model: 'servicios',
            key: 'id_servicio',
        },
    },
}, {
    tableName: 'cambios',
    timestamps: false,
});

Cambio.belongsTo(Usuario, { foreignKey: 'id_tecnico', targetKey: 'id_usuario' });
Cambio.belongsTo(Servicio, { foreignKey: 'id_servicio', targetKey: 'id_servicio' });

module.exports = Cambio;
