const express = require('express');
const router = express.Router();
const Ticket = require('../models/Ticket');
const moment = require('moment'); //con moment podemos convertir la fecha al formato local

// Ruta para contar el total de tickets
router.get('/count', async (req, res) => {
    try {
        const Ticket = require('../models/Ticket');
        const total = await Ticket.count();
        res.json({ total });
    } catch (error) {
        console.error('Error al contar tickets:', error);
        res.status(500).json({ msg: 'Error al contar tickets' });
    }
});

// Endpoint para crear un ticket

router.post('/create', async (req, res) => {
    try {
        const { usuario_id, categoria_id, servicio_id, descripcion, tipo_ticket, sla_id } = req.body;

        // Validar los datos
        if (!usuario_id || !categoria_id || !servicio_id || !descripcion || !tipo_ticket || !sla_id) {
            return res.status(400).json({ success: false, msg: 'Todos los campos son obligatorios.' });
        }

        // Crear el ticket
        const nuevoTicket = await Ticket.create({
            tipo_ticket,
            titulo_ticket: `Ticket para servicio ${servicio_id}`,
            desc_ticket: descripcion,
            fe_ini_ticket: new Date(),
            estado_ticket: 'abierto',
            id_usuario: usuario_id,
            id_categoria: categoria_id,
            id_servicio: servicio_id,
            id_sla: sla_id,
            fe_lim_ticket: new Date(Date.now() + (sla_id === 1 ? 8 : 24) * 60 * 60 * 1000), // SLA en horas
            cump_sla: false,
            mensaje_finalizacion: null, // Inicialmente no hay mensaje de finalización
        });

        res.status(201).json({ success: true, ticket: nuevoTicket });
    } catch (error) {
        console.error('Error al crear el ticket:', error);
        res.status(500).json({ success: false, msg: 'Error al crear el ticket' });
    }
});

//Endpoint para obtener tickets de un usuario
router.get('/user/:id', async (req, res) => {
    try {
        const { id } = req.params;

        // Obtener tickets del usuario
        const tickets = await Ticket.findAll({ where: { id_usuario: id } });

        // Ajustar las fechas al formato local
        const ticketsConFechasLocales = tickets.map(ticket => ({
            ...ticket.toJSON(),
            fe_ini_ticket: moment(ticket.fe_ini_ticket).utcOffset('-04:00').format('YYYY-MM-DD HH:mm:ss'),
            fe_lim_ticket: moment(ticket.fe_lim_ticket).utcOffset('-04:00').format('YYYY-MM-DD HH:mm:ss'),
        }));

        res.json(ticketsConFechasLocales);

    } catch (error) {
        console.error('Error al obtener los tickets del usuario:', error);
        res.status(500).json({ success: false, msg: 'Error al obtener los tickets' });
    }
});

//Endpoint para obtener tickets pendientes
router.get('/pending', async (req, res) => {
    try {
        const tickets = await Ticket.findAll({ where: { id_agente: null } });

        res.json(tickets);
    } catch (error) {
        console.error('Error al obtener los tickets pendientes:', error);
        res.status(500).json({ success: false, msg: 'Error al obtener los tickets pendientes' });
    }
});

//Endpoint para asignar un ticket a un agente
router.post('/assign/:id', async (req, res) => {
    try {
        const { id } = req.params;
        const { agente_id } = req.body;

        // Asignar el ticket al agente
        const ticket = await Ticket.findByPk(id);
        if (!ticket) {
            return res.status(404).json({ success: false, msg: 'Ticket no encontrado' });
        }

        ticket.id_agente = agente_id;
        ticket.estado_ticket = 'en proceso';
        await ticket.save();

        res.json({ success: true, ticket });
    } catch (error) {
        console.error('Error al asignar el ticket:', error);
        res.status(500).json({ success: false, msg: 'Error al asignar el ticket' });
    }
});

//Endpoint para obtener los tickets asignados a un agente
router.get('/agent/:id', async (req, res) => {
    try {
        const { id } = req.params;

        console.log('ID del agente:', id);

        // Obtener los tickets asignados al agente
        const tickets = await Ticket.findAll({
            where: {
                id_agente: id,
            }
        });

        console.log('Tickets encontrados:', tickets);

        if (!tickets || tickets.length === 0) {
            return res.status(404).json({ msg: 'No tienes tickets asignados.' });
        }

        // Ajustar las fechas al formato local
        const ticketsConFechasLocales = tickets.map(ticket => ({
            ...ticket.toJSON(),
            fe_ini_ticket: ticket.fe_ini_ticket
                ? moment(ticket.fe_ini_ticket).utcOffset('-04:00').format('YYYY-MM-DD HH:mm:ss')
                : null,
            fe_lim_ticket: ticket.fe_lim_ticket
                ? moment(ticket.fe_lim_ticket).utcOffset('-04:00').format('YYYY-MM-DD HH:mm:ss')
                : null,
        }));

        res.json(ticketsConFechasLocales);

    } catch (error) {
        console.error('Error al obtener los tickets asignados:', error);
        res.status(500).json({ msg: 'Error al obtener los tickets asignados.' });
    }
});

//Endpoint para finalizar un ticket
router.post('/finalize/:id', async (req, res) => {
    try {
        const { id } = req.params;
        const { mensaje_finalizacion } = req.body;
        // Buscar el ticket por ID
        const ticket = await Ticket.findByPk(id);
        if (!ticket) {
            return res.status(404).json({ success: false, msg: 'Ticket no encontrado.' });
        }

        // Actualizar el estado del ticket a "finalizado"
        const ahora = new Date();
        const cumpleSLA = ahora <= ticket.fe_lim_ticket;

        ticket.estado_ticket = 'finalizado';
        ticket.fe_fin_ticket = ahora;
        ticket.cump_sla = cumpleSLA;
        ticket.mensaje_finalizacion = mensaje_finalizacion;
        await ticket.save();

        res.json({ success: true, msg: 'Ticket finalizado correctamente.' });
    } catch (error) {
        console.error('Error al finalizar el ticket:', error);
        res.status(500).json({ success: false, msg: 'Error al finalizar el ticket.' });
    }
});

router.get('/estadisticas', async (req, res) => {
    try {
        const Ticket = require('../models/Ticket');

        // Tickets por estado
        const estados = await Ticket.findAll({
            attributes: [
                'estado_ticket',
                [Ticket.sequelize.fn('COUNT', Ticket.sequelize.col('estado_ticket')), 'cantidad']
            ],
            group: ['estado_ticket']
        });

        // Tickets por categoría (ajusta el campo si es necesario)
        const categorias = await Ticket.findAll({
            attributes: [
                'id_sla',
                [Ticket.sequelize.fn('COUNT', Ticket.sequelize.col('id_sla')), 'cantidad']
            ],
            group: ['id_sla']
        });

        const por_estado = {};
        estados.forEach(e => {
            por_estado[e.estado_ticket] = parseInt(e.dataValues.cantidad, 10);
        });

        const por_categoria = {};
        categorias.forEach(c => {
            por_categoria[c.id_sla] = parseInt(c.dataValues.cantidad, 10);
        });

        res.json({ por_estado, por_categoria });
    } catch (error) {
        console.error('Error al obtener estadísticas:', error);
        res.status(500).json({ msg: 'Error al obtener estadísticas' });
    }
});

// Endpoint para obtener el detalle de un ticket por ID
router.get('/:id', async (req, res) => {
    try {
        const { id } = req.params;
        const Ticket = require('../models/Ticket');
        const Usuario = require('../models/Usuario');
        const Servicio = require('../models/Servicio');

        // Usa los alias EXACTOS definidos en tus asociaciones
        const ticket = await Ticket.findOne({
            where: { id_ticket: id },
            include: [
                { model: Usuario, as: 'Usuario', attributes: ['id_usuario', 'nom_usuario', 'ape_usuario', 'email_usuario'] },
                { model: Servicio, as: 'Servicio', attributes: ['id_servicio', 'nom_servicio'] },
                { model: Usuario, as: 'Agente', attributes: ['id_usuario', 'nom_usuario', 'ape_usuario', 'email_usuario'], required: false }
            ]
        });

        if (!ticket) {
            return res.status(404).json({ msg: 'Ticket no encontrado' });
        }

        res.json({
            id_ticket: ticket.id_ticket,
            estado_ticket: ticket.estado_ticket,
            tipo_ticket: ticket.tipo_ticket,
            desc_ticket: ticket.desc_ticket,
            fe_ini_ticket: ticket.fe_ini_ticket,
            fe_lim_ticket: ticket.fe_lim_ticket,
            fe_fin_ticket: ticket.fe_fin_ticket,
            cump_sla: ticket.cump_sla,
            mensaje_finalizacion: ticket.mensaje_finalizacion,
            usuario: ticket.Usuario ? `${ticket.Usuario.nom_usuario} ${ticket.Usuario.ape_usuario}` : ticket.id_usuario,
            servicio: ticket.Servicio ? ticket.Servicio.nom_servicio : ticket.id_servicio,
            agente: ticket.Agente ? `${ticket.Agente.nom_usuario} ${ticket.Agente.ape_usuario}` : ticket.id_agente
        });
    } catch (error) {
        console.error('Error al obtener el ticket:', error);
        res.status(500).json({ msg: 'Error al obtener el ticket' });
    }
});


module.exports = router;