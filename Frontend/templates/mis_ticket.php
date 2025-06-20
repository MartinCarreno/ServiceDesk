<?php
include '../includes/session_validation.php'; // Validar sesión
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
                <li><a href=<?php if ($_SESSION['usuario']['tipo'] === 'usuario') {
                                "../user/user_dashboard.php";
                                exit();
                            } else {
                                "../agent/agent_dashboard.php";
                                exit();
                            } ?>>
                        Inicio</a></li>
                <li><a href="../templates/mis_ticket.php">Mis Tickets</a></li>
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
        <?php
        // Obtener tickets pendientes desde el backend
        $url = 'http://localhost:3000/api/tickets/pending';
        $response = @file_get_contents($url);
        $tickets = $response ? json_decode($response, true) : [];
        ?>

        <div class="ticket-grid">
            <?php if (is_array($tickets) && !empty($tickets)): ?>
                <?php foreach ($tickets as $ticket): ?>
                    <div class="ticket-card priority-<?php echo strtolower($ticket['prioridad'] ?? 'medium'); ?>">
                        <div class="ticket-header">
                            <div class="ticket-id">#TK-<?php echo htmlspecialchars($ticket['id_ticket']); ?></div>
                            <div class="ticket-status status-<?php echo htmlspecialchars($ticket['estado_ticket']); ?>">
                                <?php echo ucfirst($ticket['estado_ticket']); ?>
                            </div>
                        </div>
                        <div class="ticket-info">
                            <div class="info-item">
                                <div class="info-label">Usuario</div>
                                <div class="info-value"><?php echo htmlspecialchars($ticket['usuario'] ?? 'Desconocido'); ?></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Servicio</div>
                                <div class="info-value"><?php echo htmlspecialchars($ticket['servicio'] ?? 'Desconocido'); ?></div>
                            </div>
                        </div>
                        <div class="ticket-description">
                            <?php echo htmlspecialchars($ticket['desc_ticket']); ?>
                        </div>
                        <div class="timestamp">
                            <?php echo htmlspecialchars($ticket['fe_ini_ticket']); ?>
                        </div>
                        <div class="ticket-actions">
                            <a href="assing_ticket.php?ticket_id=<?php echo $ticket['id_ticket']; ?>" class="btn btn-primary">👨‍💼 Atender</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-state-icon">📋</div>
                    <h3>No hay tickets disponibles</h3>
                    <p>Cuando crees nuevos tickets, aparecerán aquí</p>
                </div>
            <?php endif; ?>
        </div>





    </main>

</body>

</html>