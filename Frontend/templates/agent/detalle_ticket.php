<?php
include '../../includes/session_validation.php'; // Validar sesión

// 1. Obtener el id_ticket desde GET
$id_ticket = $_GET['id_ticket'] ?? null;
$ticket = null;
$error = null;

if ($id_ticket) {
    // 2. Consultar el ticket al backend
    $url = "http://localhost:3000/api/tickets/$id_ticket";
    $response = @file_get_contents($url);
    if ($response) {
        $ticket = json_decode($response, true);
    } else {
        $error = "No se pudo obtener la información del ticket.";
    }
} else {
    $error = "No se proporcionó un ID de ticket.";
}

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
                <li><a href="../agent/crear_activo.php">Agregar Activo</a></li>
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
        <section class="section fade-in">
            <div class="section-header">
                Detalle del Ticket
            </div>
            <div class="ticket-container">
                <?php if ($error): ?>
                    <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
                <?php elseif ($ticket): ?>
                    <h2>#TK-<?php echo htmlspecialchars($ticket['id_ticket']); ?></h2>
                    <div class="ticket-detail-section">
                        <p><strong>Estado:</strong> <?php echo ucfirst(htmlspecialchars($ticket['estado_ticket'])); ?></p>
                        <p><strong>Tipo:</strong> <?php echo ucfirst(htmlspecialchars($ticket['tipo_ticket'])); ?></p>
                        <p><strong>Usuario:</strong> <?php echo htmlspecialchars($ticket['usuario'] ?? $ticket['id_usuario'] ?? 'Desconocido'); ?></p>
                        <p><strong>Servicio:</strong> <?php echo htmlspecialchars($ticket['servicio'] ?? $ticket['id_servicio'] ?? 'Desconocido'); ?></p>
                        <p><strong>Agente asignado:</strong> <?php echo htmlspecialchars($ticket['agente'] ?? $ticket['id_agente'] ?? 'No asignado'); ?></p>
                    </div>
                    <div class="ticket-detail-section">
                        <p><strong>Descripción:</strong> <?php echo htmlspecialchars($ticket['desc_ticket']); ?></p>
                    </div>
                    <div class="ticket-detail-section">
                        <p><strong>Fecha de creación:</strong>
                            <?php
                            if (!empty($ticket['fe_ini_ticket'])) {
                                $dt = new DateTime($ticket['fe_ini_ticket'], new DateTimeZone('UTC'));
                                $dt->setTimezone(new DateTimeZone('America/Santiago'));
                                echo $dt->format('Y-m-d H:i');
                            } else {
                                echo 'No disponible';
                            }
                            ?>
                        </p>
                        <p><strong>Fecha límite SLA:</strong>
                            <?php
                            if (!empty($ticket['fe_lim_ticket'])) {
                                $dt = new DateTime($ticket['fe_lim_ticket'], new DateTimeZone('UTC'));
                                $dt->setTimezone(new DateTimeZone('America/Santiago'));
                                echo $dt->format('Y-m-d H:i');
                            } else {
                                echo 'No disponible';
                            }
                            ?>
                        </p>
                        <p><strong>Fecha de finalización:</strong>
                            <?php
                            if (!empty($ticket['fe_fin_ticket'])) {
                                $dt = new DateTime($ticket['fe_fin_ticket'], new DateTimeZone('UTC'));
                                $dt->setTimezone(new DateTimeZone('America/Santiago'));
                                echo $dt->format('Y-m-d H:i');
                            } else {
                                echo 'No finalizado';
                            }
                            ?>
                        </p>
                        <p>
                            <strong>Cumplió SLA:</strong>
                            <?php
                            if (isset($ticket['cump_sla'])) {
                                $slaClass = $ticket['cump_sla'] ? 'sla-ok' : 'sla-fail';
                                echo "<span class=\"$slaClass\">" . ($ticket['cump_sla'] ? '✅ Sí' : '❌ No') . "</span>";
                            } else {
                                echo '<span class="sla-na">No aplica</span>';
                            }
                            ?>
                        </p>
                        <p><strong>Mensaje de resolución:</strong> <?php echo htmlspecialchars($ticket['mensaje_finalizacion'] ?? 'No hay mensaje'); ?></p>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <div class="empty-state-icon">📋</div>
                        <h3>No se encontró el ticket</h3>
                    </div>
                <?php endif; ?>
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