<?php include '../../includes/session_validation.php'; ?>
<?php $id = isset($_GET['id']) ? intval($_GET['id']) : 0; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle del Cambio</title>
    <link rel="stylesheet" href="../../assets/css/app.css">
</head>
<body class="dashboard">
    <nav class="navbar">
        <ul>
            <li><a href="dashboard.php">Inicio</a></li>
            <li><a href="mis_tickets.php">Mis Tickets</a></li>
            <li><a href="cambios.php">Cambios</a></li>
            <li><a href="cambio_form.php">Crear Cambio</a></li>
            <li><a href="logout.php">Cerrar Sesión</a></li>
        </ul>
    </nav>
    <main class="main-content">
        <h1>Detalle del Cambio</h1>
        <div id="detalle-cambio"></div>
        <a href="cambios.php" class="btn btn-secondary" style="margin-top:2rem;">Volver al listado</a>
    </main>
    <script>
    fetch('http://localhost:3000/api/cambios/<?php echo $id; ?>')
        .then(res => res.json())
        .then(c => {
            document.getElementById('detalle-cambio').innerHTML = `
                <h2>${c.titulo_cambio}</h2>
                <p><strong>Descripción:</strong> ${c.desc_cambio}</p>
                <p><strong>Tipo:</strong> ${c.tipo_cambio}</p>
                <p><strong>Fecha:</strong> ${new Date(c.fecha_cambio).toLocaleDateString()}</p>
                <p><strong>Riesgo:</strong> ${c.riesgo_cambio}</p>
                <p><strong>Estado:</strong> ${c.estado_cambio}</p>
            `;
        });
    </script>
</body>
</html>