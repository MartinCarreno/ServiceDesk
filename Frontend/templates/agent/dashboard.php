<?php
include '../../includes/session_validation.php'; // Validar sesión
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/app.css">
    <title>Panel de Agente - Tickets</title>
</head>

<body class="dashboard">
    <nav class="navbar">
        <nav>
            <ul>
                <li><a href="../agent/dashboard.php">Inicio</a></li>
                <li><a href="../agent/mis_tickets.php">Mis Ticket</a></li>
                <li><a href="../agent/tickets_pendientes.php">Tickets Pendientes</a></li>
                <li><a href="../agent/mis_tickets_asignados.php">Tickets Asignados</a></li>
                <li><a href="../agent/tickets_finalizados.php">Tickets finalizados</a></li>
                <li><a href="../agent/articulos.php">Articulos</a></li>
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
            <p>Panel de control de tickets - Gestiona y da seguimiento a todos los tickets del sistema</p>
        </div>

        <?php
        // Tickets Pendientes
        $url = 'http://localhost:3000/api/tickets/pending';
        $response = @file_get_contents($url);
        $ticketsPendientes = $response ? json_decode($response, true) : [];

        // Mis Tickets Pendientes (asignados al agente)
        $ticketsAsignados = [];
        if (isset($_SESSION['usuario']['id'])) {
            $url = 'http://localhost:3000/api/tickets/agent/' . $_SESSION['usuario']['id'];
            $response = @file_get_contents($url);
            $ticketsAsignados = $response ? json_decode($response, true) : [];
        }

        // Mis Tickets (creados por el agente)
        $ticketsCreados = [];
        if (isset($_SESSION['usuario']['id'])) {
            $url = 'http://localhost:3000/api/tickets/user/' . $_SESSION['usuario']['id'];
            $response = @file_get_contents($url);
            $ticketsCreados = $response ? json_decode($response, true) : [];
        }

        // Tickets Finalizados (asignados al agente y finalizados)
        $ticketsFinalizados = [];
        if (isset($_SESSION['usuario']['id'])) {
            $url = 'http://localhost:3000/api/tickets/agent/' . $_SESSION['usuario']['id'] . '?estado=finalizado';
            $response = @file_get_contents($url);
            $ticketsFinalizados = array_filter($ticketsAsignados, function ($t) {
                return isset($t['estado_ticket']) && $t['estado_ticket'] === 'finalizado';
            });
        }
        ?>

        <!-- Tickets Pendientes -->
        <section class="section fade-in">
            <div class="section-header">
                🔔 Tickets Pendientes
            </div>
            <div class="tickets-container">
                <div class="ticket-grid">
                    <?php if (is_array($ticketsPendientes) && !empty($ticketsPendientes)): ?>
                        <?php foreach ($ticketsPendientes as $ticket): ?>
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
                                        <div class="info-value"><?php echo htmlspecialchars($ticket['usuario'] ?? $ticket['id_usuario'] ?? 'Desconocido'); ?></div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Servicio</div>
                                        <div class="info-value"><?php echo htmlspecialchars($ticket['servicio'] ?? $ticket['id_sla'] ?? 'Desconocido'); ?></div>
                                    </div>
                                </div>
                                <div class="ticket-description">
                                    <?php echo htmlspecialchars($ticket['desc_ticket']); ?>
                                </div>
                                <div class="timestamp">
                                    <?php echo htmlspecialchars($ticket['fe_ini_ticket']); ?>
                                </div>
                                <div class="ticket-actions">
                                    <a href="../../includes/assing_ticket.php?ticket_id=<?php echo $ticket['id_ticket']; ?>" class="btn btn-primary">👨‍💼 Atender</a>
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
            </div>
        </section>

        <!-- Mis Tickets Pendientes -->
        <section class="section fade-in">
            <div class="section-header">
                👤 Mis Tickets Asignados Pendientes
            </div>
            <div class="tickets-container">
                <div class="ticket-grid">
                    <?php if (is_array($ticketsAsignados) && !empty($ticketsAsignados)): ?>
                        <?php foreach ($ticketsAsignados as $ticket): ?>
                            
                            <?php if ($ticket['estado_ticket'] === 'en proceso'): ?>
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
                                        <button class="btn btn-success" onclick="finalizarTicket(<?php echo $ticket['id_ticket']; ?>, this)">✅ Finalizar</button>
                                    </div>
                                </div>
                                
                                <?php elseif(empty($ticketsAsignados)): ?>
                                <div class="empty-state">
                                    <div class="empty-state-icon">📋</div>
                                    <h3>No tienes tickets asignados</h3>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-state">
                            <div class="empty-state-icon">📋</div>
                            <h3>No tienes tickets asignados</h3>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- Mis Tickets Creados -->
        <section class="section fade-in">
            <div class="section-header">
                📋 Mis Tickets Creados
            </div>
            <div class="tickets-container">
                <div class="ticket-grid">
                    <?php if (is_array($ticketsCreados) && !empty($ticketsCreados)): ?>
                        <?php foreach ($ticketsCreados as $ticket): ?>
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
                                    <a href="detalle_ticket.php?id_ticket=<?php echo $ticket['id_ticket']; ?>" class="btn btn-primary">👁️ Ver Detalles</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-state">
                            <div class="empty-state-icon">📋</div>
                            <h3>No tienes tickets creados</h3>
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


    </main>

    <script>
        // Animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.section').forEach(section => {
            section.style.opacity = '0';
            section.style.transform = 'translateY(30px)';
            section.style.transition = 'all 0.6s ease';
            observer.observe(section);
        });

        // Ticket finalization function
        async function finalizarTicket(ticketId, button) {
            const mensaje = prompt('Deja un mensaje de cierre para este ticket:');
            if (mensaje === null) return;

            try {
                const originalText = button.innerHTML;
                button.innerHTML = '⏳ Procesando...';
                button.disabled = true;

                const response = await fetch(`../../includes/finalize_ticket.php?ticket_id=${ticketId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        mensaje_finalizacion: mensaje
                    })
                });

                const result = await response.json();

                if (result.success) {
                    // Animar y mover el ticket a la sección de finalizados
                    const card = button.closest('.ticket-card');
                    card.style.transform = 'scale(0.95)';
                    card.style.opacity = '0.5';

                    setTimeout(() => {
                        // Cambiar el estado visualmente
                        card.querySelector('.ticket-status').textContent = 'Finalizado';
                        card.querySelector('.ticket-status').className = 'ticket-status status-finalizado';
                        // Eliminar el botón de finalizar
                        const actions = card.querySelector('.ticket-actions');
                        if (actions) actions.remove();

                        // Mover el card a la sección de finalizados
                        document.getElementById('finalizados-grid').prepend(card);

                        // Restaurar estilos
                        card.style.transform = '';
                        card.style.opacity = '';
                        showNotification('✅ Ticket finalizado correctamente', 'success');
                    }, 300);
                } else {
                    button.innerHTML = originalText;
                    button.disabled = false;
                    showNotification(result.msg || '❌ No se pudo finalizar el ticket', 'error');
                }
            } catch (error) {
                console.error('Error al finalizar el ticket:', error);
                button.innerHTML = originalText;
                button.disabled = false;
                showNotification('❌ Error de conexión', 'error');
            }
        }

        // Notification system
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 1rem 1.5rem;
                border-radius: 10px;
                color: white;
                font-weight: 500;
                z-index: 10000;
                animation: slideIn 0.3s ease;
                max-width: 300px;
                box-shadow: 0 4px 20px rgba(0,0,0,0.2);
            `;

            const colors = {
                success: 'linear-gradient(135deg, #51cf66, #40c057)',
                error: 'linear-gradient(135deg, #ff6b6b, #ee5a52)',
                info: 'linear-gradient(135deg, #667eea, #764ba2)'
            };

            notification.style.background = colors[type] || colors.info;
            notification.textContent = message;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // Add CSS for notification animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOut {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>

</html>