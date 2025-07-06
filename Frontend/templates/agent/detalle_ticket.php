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

    <main class="main-content" >
        <section class="section fade-in">
            <div class="section-header">
                Ticket 
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