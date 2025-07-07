<?php include '../../includes/session_validation.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Cambios</title>
    <link rel="stylesheet" href="../../assets/css/app.css">
</head>
<body class="dashboard">
    <nav class="navbar">
        <ul>
            <li><a href="dashboard.php">Inicio</a></li>
            <li><a href="mis_tickets.php">Mis Tickets</a></li>
            <li><a href="cambios.php" class="active">Cambios</a></li>
            <li><a href="cambio_form.php">Crear Cambio</a></li>
            <li><a href="logout.php">Cerrar Sesión</a></li>
        </ul>
    </nav>
    <main class="main-content">
        <h1>Listado de Cambios</h1>
        <div id="cambios-list"></div>
        <a href="cambio_form.php" class="btn btn-primary" style="margin-top:2rem;">Crear Nuevo Cambio</a>
    </main>
    <script>
    // Cargar cambios desde la API
    fetch('http://localhost:3000/api/cambios')
        .then(res => res.json())
        .then(data => {
            const cont = document.getElementById('cambios-list');
            if (data.length === 0) {
                cont.innerHTML = "<p>No hay cambios registrados.</p>";
                return;
            }
            
            cont.innerHTML = data.map(c => `
                <div class="cambio-item">
                    <strong>${c.titulo_cambio}</strong> <br>
                    <span>${c.tipo_cambio} | ${c.estado_cambio} | ${c.Servicio ? c.Servicio.nom_servicio : ''} | ${new Date(c.fecha_cambio).toLocaleDateString()}</span><br>
                    <a href="cambio_view.php?id=${c.id_cambio}" class="btn btn-secondary" style="margin-top:8px;">Ver Detalle</a>
                </div>
            `).join('');
            });
    </script>
</body>
</html>