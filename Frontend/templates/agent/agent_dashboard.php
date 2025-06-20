<?php
include '../../includes/session_validation.php'; // Validar sesión
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/app.css">
    <title>Panel de Agente</title>
</head>
<body class="dashboard">
    <nav class="navbar">
        <nav>
            <ul>
                <li><a href="../agent/agent_dashboard.php">Inicio</a></li>
                <li><a href="../agent/agent_dashboard.php">Mis Ticket</a></li>
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

    <h2>Crear Ticket</h2>
    <a href="../create_ticket_form.php">
        <button>Ir a Crear Ticket</button>
    </a>

    <h2>Tickets Pendientes</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Servicio</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Obtener tickets pendientes desde el backend
            $url = 'http://localhost:3000/api/tickets/pending';
            $response = @file_get_contents($url);
            $tickets = $response ? json_decode($response, true) : null;

            if (is_array($tickets) && !empty($tickets)) {
                foreach ($tickets as $ticket) {
                    echo "<tr>
                            <td>{$ticket['id_ticket']}</td>
                            <td>" . (isset($ticket['id_usuario']) ? $ticket['id_usuario'] : 'Desconocido') . "</td>
                            <td>" . (isset($ticket['id_sla']) ? "SLA {$ticket['id_sla']}" : 'Desconocido') . "</td>
                            <td>" . (isset($ticket['desc_ticket']) ? $ticket['desc_ticket'] : 'Sin descripción') . "</td>
                            <td>" . (isset($ticket['estado_ticket']) ? $ticket['estado_ticket'] : 'Sin estado') . "</td>
                            <td><a href='../../includes/assing_ticket.php?ticket_id={$ticket['id_ticket']}'>Atender</a></td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No hay tickets pendientes.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <h2>Mis Tickets Pendientes</h2>
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
            // Obtener tickets asignados al agente desde el backend
            if (isset($_SESSION['usuario']['id'])) {
                $url = 'http://localhost:3000/api/tickets/agent/' . $_SESSION['usuario']['id'];
                $response = @file_get_contents($url);
                $tickets = $response ? json_decode($response, true) : null;

                if (is_array($tickets) && !empty($tickets)) {
                    foreach ($tickets as $ticket) {
                        echo "<tr>
                            
                            <td>{$ticket['id_ticket']}</td>
                            <td>" . (isset($ticket['id_sla']) ? "SLA {$ticket['id_sla']}" : 'Desconocido') . "</td>
                            <td>" . (isset($ticket['desc_ticket']) ? $ticket['desc_ticket'] : 'Sin descripción') . "</td>
                            <td>" . (isset($ticket['estado_ticket']) ? $ticket['estado_ticket'] : 'Sin estado') . "</td>
                            <td>" . (isset($ticket['fe_ini_ticket']) ? $ticket['fe_ini_ticket'] : 'Sin Fecha') . "</td>
                            
                            
                            
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No tienes tickets asignados.</td></tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No se pudo identificar al agente. Por favor, inicie sesión nuevamente.</td></tr>";
            }
            ?>
        </tbody>
    </table>

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

    <a href="../logout.php">Cerrar sesión</a>

    <script>
        async function finalizarTicket(ticketId, button) {
            if (!confirm('¿Estás seguro de que deseas finalizar este ticket?')) {
                return;
            }

            try {
                const response = await fetch(`../../includes/finalize_ticket.php?ticket_id=${ticketId}`, {
                    method: 'POST'
                });

                const result = await response.json();

                if (result.success) {
                    // Eliminar la fila de la tabla
                    const row = button.closest('tr');
                    row.remove();
                    alert('El ticket se finalizó correctamente.');
                } else {
                    alert(result.msg || 'No se pudo finalizar el ticket.');
                }
            } catch (error) {
                console.error('Error al finalizar el ticket:', error);
                alert('Ocurrió un error al intentar finalizar el ticket.');
            }
        }
    </script>    
    </main>
   

</body>
</html>