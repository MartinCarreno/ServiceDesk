<?php
include '../../includes/session_validation.php'; // Validar sesión
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/app.css">
    <title>Panel de Usuario</title>
</head>
<body class="dashboard">
    <nav class="navbar">
        <nav>
            <ul>
                <li><a href="../agent/dashboard.php">Inicio</a></li>
                <li><a href="../agent/mis_tickets.php">Mis Ticket</a></li>
                <li><a href="../agent/mis_tickets.php">Tickets Pendientes</a></li>
                <li><a href="../agent/mis_tickets.php">Tickets finalizados</a></li>
                <li><a href="../agent/mis_tickets.php">Articulos</a></li>
                <li><a href="../create_ticket_form.php">Crear Ticket</a></li>
                <li><a href="../logout.php">Cerrar Sesión</a></li>
            </ul>
        </nav>

    </nav>

    <header>
    <a href="../create_ticket_form.php">
        <button>+</button>
    </a>
    </header>

    <main class="main-content">
        
    </main>
    
</body>
</html>