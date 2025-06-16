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
                <li><a href="../user/user_dashboard.php">Inicio</a></li>
                <li><a href="../mis_ticket.php">Mis Tickets</a></li>
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
        <h1>Bienvenido, <?php echo isset($_SESSION['usuario']['email']) ? $_SESSION['usuario']['email'] : 'Invitado'; ?></h1>
    

    <h2>Mis Tickets</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Servicio</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Fecha de Creación</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Obtener tickets del usuario desde el backend
        if (isset($_SESSION['usuario']['id'])) {
            $url = 'http://localhost:3000/api/tickets/user/' . $_SESSION['usuario']['id'];
            $response = @file_get_contents($url); // Usa @ para suprimir errores si la URL falla
            $tickets = $response ? json_decode($response, true) : null;

            if (is_array($tickets) && !empty($tickets)) {
                foreach ($tickets as $ticket) {
                    echo "<tr>
                            <td>{$ticket['id_ticket']}</td>
                            <td>" . (isset($ticket['id_sla']) ? "SLA {$ticket['id_sla']}" : 'Desconocido') . "</td>
                            <td>" . (isset($ticket['desc_ticket']) ? $ticket['desc_ticket'] : 'Sin descripción') . "</td>
                            <td>" . (isset($ticket['estado_ticket']) ? $ticket['estado_ticket'] : 'Sin estado') . "</td>
                            <td>" . (isset($ticket['fe_ini_ticket']) ? $ticket['fe_ini_ticket'] : 'No hay registro') . "</td>
                            
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No hay tickets disponibles o ocurrió un error al obtener los datos.</td></tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No se pudo identificar al usuario. Por favor, inicie sesión nuevamente.</td></tr>";
        }
            ?>
        </tbody>
    </table>

    </main>
    
</body>
</html>