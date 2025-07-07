const express = require('express');
const cors = require('cors');
const dotenv = require('dotenv');
const sequelize = require('./config/database'); // Importar la configuración de la base de datos
const authRoutes = require('./routes/authRoutes'); // Importar las rutas de autenticación
const serviceRoutes = require('./routes/serviceRoutes');
const ticketRoutes = require('./routes/ticketRoutes');
const categoryRoutes = require('./routes/categoryRoutes');
const articuloRoutes = require('./routes/articuloRoutes');
const activoRoutes = require('./routes/activoRoutes');
const cambioRoutes = require('./routes/cambioRoutes');


require('./models/associations');

dotenv.config();
const app = express();

app.use(cors());
app.use(express.json()); // Para parsear JSON en las peticiones

// Rutas
app.use('/api/auth', authRoutes); // Usar las rutas de autenticación
app.use('/api/services', serviceRoutes);
app.use('/api/tickets', ticketRoutes);
app.use('/api/categories', categoryRoutes);
app.use('/api/articulos', articuloRoutes);
app.use('/api/activos', activoRoutes);
app.use('/api/cambios', cambioRoutes);


// Conectar a la base de datos y luego iniciar el servidor
sequelize.authenticate()
  .then(() => {
    console.log('Conectado a PostgreSQL');
    return sequelize.sync( {force: false} ); // Sincroniza los modelos con la base de datos
  })
  .then(() => {
    app.listen(process.env.PORT, () => {
      console.log(`Servidor corriendo en puerto ${process.env.PORT}`);
    });
  })
  .catch(err => console.error('Error en la conexión:', err));
