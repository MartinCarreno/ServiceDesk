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
                <li><a href="../agent/agent_dashboard.php">Inicio</a></li>
                <li><a href="../agent/agent_dashboard.php">Mis Ticket</a></li>
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
            <h1>👋 Bienvenido, agent@example.com</h1>
            <p>Panel de control de tickets - Gestiona y da seguimiento a todos los tickets del sistema</p>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number"></div>
                    <div class="stat-label">Tickets Pendientes</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">8</div>
                    <div class="stat-label">Mis Tickets</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">25</div>
                    <div class="stat-label">Completados Hoy</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">4.8</div>
                    <div class="stat-label">Rating Promedio</div>
                </div>
            </div>
        </div>

        <?php
// Obtener tickets pendientes desde el backend
$url = 'http://localhost:3000/api/tickets/pending';
$response = @file_get_contents($url);
$ticketsPendientes = $response ? json_decode($response, true) : [];
?>
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

       <?php
// Obtener tickets asignados al agente desde el backend
$ticketsAsignados = [];
if (isset($_SESSION['usuario']['id'])) {
    $url = 'http://localhost:3000/api/tickets/agent/' . $_SESSION['usuario']['id'];
    $response = @file_get_contents($url);
    $ticketsAsignados = $response ? json_decode($response, true) : [];
}
?>
<section class="section fade-in">
    <div class="section-header">
        👤 Mis Tickets Pendientes
    </div>
    <div class="tickets-container">
        <div class="ticket-grid">
            <?php if (is_array($ticketsAsignados) && !empty($ticketsAsignados)): ?>
                <?php foreach ($ticketsAsignados as $ticket): ?>
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
                                <div class="info-value"><?php echo htmlspecialchars($ticket['servicio'] ?? 'Desconocido'); ?></div>
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

        <!-- Mis Tickets -->
        <section class="section fade-in">
            <div class="section-header">
                📋 Mis Tickets Creados
            </div>
            <div class="tickets-container">
                <div class="ticket-grid">
                    <!-- Sample User Ticket -->
                    <div class="ticket-card priority-low">
                        <div class="ticket-header">
                            <div class="ticket-id">#TK-004</div>
                            <div class="ticket-status status-completed">Completado</div>
                        </div>
                        <div class="ticket-info">
                            <div class="info-item">
                                <div class="info-label">Servicio</div>
                                <div class="info-value">SLA Básico</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Fecha de Creación</div>
                                <div class="info-value">2024-01-14 14:20</div>
                            </div>
                        </div>
                        <div class="ticket-description">
                            Solicitud de cambio de contraseña para acceso al portal de empleados.
                        </div>
                        <div class="timestamp">Completado ayer</div>
                        <div class="ticket-actions">
                            <a href="#" class="btn btn-primary">👁️ Ver Detalles</a>
                        </div>
                    </div>

                    <!-- Empty State Example -->
                    <div class="empty-state" style="display: none;">
                        <div class="empty-state-icon">📋</div>
                        <h3>No hay tickets disponibles</h3>
                        <p>Cuando crees nuevos tickets, aparecerán aquí</p>
                    </div>
                </div>
            </div>
        </section>

        <div style="text-align: center; margin: 2rem 0;">
            <a href="logout.php" class="btn btn-danger">🚪 Cerrar Sesión</a>
        </div>
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

        // Ticket finalization function (same as original)
        async function finalizarTicket(ticketId, button) {
            if (!confirm('¿Estás seguro de que deseas finalizar este ticket?')) {
                return;
            }

            try {
                // Add loading state
                const originalText = button.innerHTML;
                button.innerHTML = '⏳ Procesando...';
                button.disabled = true;

                const response = await fetch(`../../includes/finalize_ticket.php?ticket_id=${ticketId}`, {
                    method: 'POST'
                });

                const result = await response.json();

                if (result.success) {
                    // Animate card removal
                    const card = button.closest('.ticket-card');
                    card.style.transform = 'scale(0.95)';
                    card.style.opacity = '0.5';
                    
                    setTimeout(() => {
                        card.remove();
                        
                        // Show success notification
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

        // Auto-refresh tickets every 30 seconds (optional)
        // setInterval(() => {
        //     window.location.reload();
        // }, 30000);
    </script>
</body>
</html>