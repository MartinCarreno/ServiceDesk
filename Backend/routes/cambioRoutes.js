const express = require('express');
const router = express.Router();
const Cambio = require('../models/Cambio');

// Listar todos los cambios (incluyendo el servicio)
router.get('/', async (req, res) => {
    try {
        const Cambio = require('../models/Cambio');
        const Servicio = require('../models/Servicio');
        const cambios = await Cambio.findAll({
            include: [{ model: Servicio, attributes: ['nom_servicio'] }]
        });
        res.json(cambios);
    } catch (error) {
        res.status(500).json({ msg: 'Error al obtener cambios' });
    }
});

// Obtener un cambio por ID (incluyendo el servicio)
router.get('/:id', async (req, res) => {
    try {
        const Cambio = require('../models/Cambio');
        const Servicio = require('../models/Servicio');
        const cambio = await Cambio.findByPk(req.params.id, {
            include: [{ model: Servicio, attributes: ['nom_servicio'] }]
        });
        if (!cambio) return res.status(404).json({ msg: 'Cambio no encontrado' });
        res.json(cambio);
    } catch (error) {
        res.status(500).json({ msg: 'Error al obtener el cambio' });
    }
});
// Crear un cambio
router.post('/', async (req, res) => {
    try {
        const cambio = await Cambio.create(req.body);
        res.status(201).json(cambio);
    } catch (error) {
        res.status(500).json({ msg: 'Error al crear el cambio' });
    }
});

// Editar un cambio
router.put('/:id', async (req, res) => {
    try {
        const cambio = await Cambio.findByPk(req.params.id);
        if (!cambio) return res.status(404).json({ msg: 'Cambio no encontrado' });
        await cambio.update(req.body);
        res.json(cambio);
    } catch (error) {
        res.status(500).json({ msg: 'Error al actualizar el cambio' });
    }
});

// Eliminar un cambio
router.delete('/:id', async (req, res) => {
    try {
        const cambio = await Cambio.findByPk(req.params.id);
        if (!cambio) return res.status(404).json({ msg: 'Cambio no encontrado' });
        await cambio.destroy();
        res.json({ msg: 'Cambio eliminado' });
    } catch (error) {
        res.status(500).json({ msg: 'Error al eliminar el cambio' });
    }
});

module.exports = router;