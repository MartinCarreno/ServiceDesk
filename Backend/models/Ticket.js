const { DataTypes } = require('sequelize');
const sequelize = require('../config/database');
const Usuario = require('./Usuario');
const Articulo = require('./Articulo');
const Servicio = require('./Servicio');
const Sla = require('./Sla');

const Ticket = sequelize.define('Ticket', {
    id_ticket: {
        type: DataTypes.BIGINT,
        primaryKey: true,
        autoIncrement: true,
    },
    id_servicio: {
    type: DataTypes.BIGINT,
    allowNull: true,
    references: {
        model: 'servicios',
        key: 'id_servicio',
    },
    },
    tipo_ticket: {
        type: DataTypes.STRING(50),
        allowNull: false,
    },
    titulo_ticket: {
        type: DataTypes.STRING(200),
        allowNull: false,
    },
    desc_ticket: {
        type: DataTypes.TEXT,
        allowNull: false,
    },
    fe_ini_ticket: {
        type: DataTypes.DATE,
        allowNull: false,
    },
    fe_fin_ticket: {
        type: DataTypes.DATE,
        allowNull: true,
    },
    estado_ticket: {
        type: DataTypes.STRING(50),
        allowNull: false,
    },
    fe_lim_ticket: {
        type: DataTypes.DATE,
        allowNull: false,
    },
    cump_sla: {
        type: DataTypes.BOOLEAN,
        allowNull: false,
    },

    mensaje_finalizacion: {
        type: DataTypes.TEXT,
        allowNull: true,
    },
}, {
    tableName: 'tickets',
    timestamps: false,
});

Ticket.belongsTo(Usuario, { foreignKey: 'id_usuario', targetKey: 'id_usuario' });
Ticket.belongsTo(Usuario, { as: 'Agente', foreignKey: 'id_agente', targetKey: 'id_usuario' });
Ticket.belongsTo(Articulo, { foreignKey: 'id_articulo', targetKey: 'id_articulo' });
Ticket.belongsTo(Servicio, { as: 'Servicio', foreignKey: 'id_servicio' });
Ticket.belongsTo(Sla, { foreignKey: 'id_sla', targetKey: 'id_sla' });

module.exports = Ticket;
