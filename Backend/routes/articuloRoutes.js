const express = require('express');
const router = express.Router();
const Articulo = require('../models/Articulo');

// GET /api/articulos - Listar todos los artículos publicados y visibles
router.get('/', async (req, res) => {
    try {
        // Solo artículos publicados y visibles para usuarios
        const articulos = await Articulo.findAll({
            where: {
                estado_articulo: 'publicado',
                visibilidad: 'publico'
            },
            order: [['fecha_articulo', 'DESC']]
        });
        res.json({ articulos });
    } catch (error) {
        console.error('Error al obtener los artículos:', error);
        res.status(500).json({ msg: 'Error al obtener los artículos' });
    }
});

module.exports = router;