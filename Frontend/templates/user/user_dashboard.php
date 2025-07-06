<?php
include '../../includes/session_validation.php'; // Validar sesión
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/app.css">
    <title>Panel de Usuario - Tickets</title>
</head>

<body class="dashboard">
    <nav class="navbar">
        <nav>
            <ul>
                <li><a href="../user/user_dashboard.php">Inicio</a></li>
                <li><a href="../user/mis_tickets.php">Mis Ticket</a></li>
                <li><a href="../user/tickets_finalizados.php">Tickets finalizados</a></li>
                <li><a href="../agent/mis_tickets.php">Articulos</a></li>
                <li><a href="../create_ticket_form.php">Crear Ticket</a></li>
                <li><a href="../logout.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </nav>

    <div class="header-actions">
        <a href="../create_ticket_form.php">
            <button class="create-btn" title="Crear Nuevo Ticket">+</button>
        </a>
    </div>

    <main class="main-content">
        <div class="welcome-section fade-in">
            <h1>👋 Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']['email'] ?? 'Invitado'); ?></h1>
            <p>Panel de usuario - Aquí puedes ver y gestionar tus tickets.</p>
        </div>

        <?php
        // Mis Tickets (creados por el usuario)
        $ticketsCreados = [];
        if (isset($_SESSION['usuario']['id'])) {
            $url = 'http://localhost:3000/api/tickets/user/' . $_SESSION['usuario']['id'];
            $response = @file_get_contents($url);
            $ticketsCreados = $response ? json_decode($response, true) : [];
        }

        // Tickets Finalizados (creados por el usuario y finalizados)
        $ticketsFinalizados = [];
        if (!empty($ticketsCreados)) {
            $ticketsFinalizados = array_filter($ticketsCreados, function($t) {
                return isset($t['estado_ticket']) && $t['estado_ticket'] === 'finalizado';
            });
        }
        ?>

        <!-- Mis Tickets Creados -->
        <section class="section fade-in">
            <div class="section-header">
                📋 Mis Tickets
            </div>
            <div class="tickets-container">
                <div class="ticket-grid">
                    <?php
                    // Solo mostrar los tickets que NO están finalizados
                    $ticketsNoFinalizados = array_filter($ticketsCreados, function($t) {
                        return isset($t['estado_ticket']) && $t['estado_ticket'] !== 'finalizado';
                    });
                    ?>
                    <?php if (is_array($ticketsNoFinalizados) && !empty($ticketsNoFinalizados)): ?>
                        <?php foreach ($ticketsNoFinalizados as $ticket): ?>
                            <div class="ticket-card priority-<?php echo strtolower($ticket['prioridad'] ?? 'medium'); ?>">
                                <div class="ticket-header">
                                    <div class="ticket-id">#TK-<?php echo htmlspecialchars($ticket['id_ticket']); ?></div>
                                    <div class="ticket-status status-<?php echo htmlspecialchars($ticket['estado_ticket']); ?>">
                                        <?php echo ucfirst($ticket['estado_ticket']); ?>
                                    </div>
                                </div>
                                <div class="ticket-info">
                                    <div class="info-item">
                                        <div class="info-label">Servicio</div>
                                        <div class="info-value"><?php echo htmlspecialchars($ticket['servicio'] ?? $ticket['id_sla'] ?? 'Desconocido'); ?></div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Fecha de Creación</div>
                                        <div class="info-value"><?php echo htmlspecialchars($ticket['fe_ini_ticket']); ?></div>
                                    </div>
                                </div>
                                <div class="ticket-description">
                                    <?php echo htmlspecialchars($ticket['desc_ticket']); ?>
                                </div>
                                <div class="timestamp">
                                    <?php echo htmlspecialchars($ticket['fe_ini_ticket']); ?>
                                </div>
                                <div class="ticket-actions">
                                    <a href="detalle_ticket.php" class="btn btn-primary">👁️ Ver Detalles</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-state">
                            <div class="empty-state-icon">📋</div>
                            <h3>No tienes tickets activos</h3>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- Tickets Finalizados -->
        <section class="section fade-in" id="finalizados-section">
            <div class="section-header">
                🏁 Tickets Finalizados
            </div>
            <div class="tickets-container">
                <div class="ticket-grid" id="finalizados-grid">
                    <?php if (is_array($ticketsFinalizados) && !empty($ticketsFinalizados)): ?>
                        <?php foreach ($ticketsFinalizados as $ticket): ?>
                            <div class="ticket-card priority-<?php echo strtolower($ticket['prioridad'] ?? 'medium'); ?>">
                                <div class="ticket-header">
                                    <div class="ticket-id">#TK-<?php echo htmlspecialchars($ticket['id_ticket']); ?></div>
                                    <div class="ticket-status status-<?php echo htmlspecialchars($ticket['estado_ticket']); ?>">
                                        <?php echo ucfirst($ticket['estado_ticket']); ?>
                                    </div>
                                </div>
                                <div class="ticket-info">
                                    <div class="info-item">
                                        <div class="info-label">Servicio</div>
                                        <div class="info-value"><?php echo htmlspecialchars($ticket['servicio'] ?? $ticket['id_sla'] ?? 'Desconocido'); ?></div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Fecha de Creación</div>
                                        <div class="info-value"><?php echo htmlspecialchars($ticket['fe_ini_ticket']); ?></div>
                                    </div>
                                </div>
                                <div class="ticket-description">
                                    <?php echo htmlspecialchars($ticket['desc_ticket']); ?>
                                </div>
                                <div class="timestamp">
                                    <?php echo htmlspecialchars($ticket['fe_ini_ticket']); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-state">
                            <div class="empty-state-icon">✅</div>
                            <h3>No tienes tickets finalizados</h3>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <div style="text-align: center; margin: 2rem 0;">
            <a href="../logout.php" class="btn btn-danger">🚪 Cerrar Sesión</a>
        </div>
    </main>
</body>
</html>