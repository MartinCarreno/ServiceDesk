const express = require('express');
const router = express.Router();
const Activo = require('../models/Activo');
const Usuario = require('../models/Usuario');

// GET /api/activos - Listar todos los activos
router.get('/', async (req, res) => {
    try {
        const activos = await Activo.findAll({
            include: [
                { model: Usuario, attributes: ['id_usuario', 'nom_usuario', 'ape_usuario', 'email_usuario'] }
            ]
        });
        res.json({ activos });
    } catch (error) {
        console.error('Error al obtener los activos:', error);
        res.status(500).json({ msg: 'Error al obtener los activos' });
    }
});

router.post('/', async (req, res) => {
    try {
        const activo = await Activo.create(req.body);
        res.status(201).json({ msg: 'Activo creado', activo });
    } catch (error) {
        console.error('Error al crear el activo:', error);
        res.status(500).json({ msg: 'Error al crear el activo' });
    }
});

module.exports = router;