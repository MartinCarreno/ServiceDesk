<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Agente - Tickets</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f5f5f5;
            color: #2c3e50;
            line-height: 1.6;
            font-size: 16px;
        }

        /* Header Styles */
        .header {
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid #e1e8ed;
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            min-height: 64px;
        }

        .nav-list {
            display: flex;
            list-style: none;
            gap: 8px;
        }

        .nav-link {
            text-decoration: none;
            color: #64748b;
            font-weight: 500;
            padding: 12px 16px;
            border-radius: 8px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-link:hover {
            background: #f8fafc;
            color: #4a90e2;
        }

        .create-ticket-btn {
            background: #4a90e2;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(74, 144, 226, 0.2);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .create-ticket-btn:hover {
            background: #357abd;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(74, 144, 226, 0.3);
        }

        /* Main Content */
        .main-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 32px 24px;
        }

        /* Welcome Section */
        .welcome-section {
            background: white;
            padding: 32px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            margin-bottom: 32px;
            text-align: center;
        }

        .welcome-section h1 {
            font-size: 32px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 12px;
        }

        .welcome-section p {
            color: #64748b;
            font-size: 18px;
            margin-bottom: 32px;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 32px;
        }

        .stat-card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            border: 1px solid #e1e8ed;
            text-align: center;
            transition: transform 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
        }

        .stat-number {
            font-size: 28px;
            font-weight: 700;
            color: #4a90e2;
            margin-bottom: 8px;
        }

        .stat-label {
            color: #64748b;
            font-size: 14px;
            font-weight: 500;
        }

        /* Section Styles */
        .section {
            margin-bottom: 32px;
        }

        .section-header {
            font-size: 24px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* Tickets Container */
        .tickets-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .ticket-grid {
            display: grid;
            gap: 0;
        }

        /* Ticket Card */
        .ticket-card {
            padding: 24px;
            border-bottom: 1px solid #e1e8ed;
            transition: all 0.2s ease;
        }

        .ticket-card:last-child {
            border-bottom: none;
        }

        .ticket-card:hover {
            background: #f8fafc;
        }

        .ticket-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .ticket-id {
            font-weight: 600;
            color: #2c3e50;
            font-size: 16px;
        }

        .ticket-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-pending {
            background: #fef3c7;
            color: #d97706;
        }

        .status-assigned {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .status-completed {
            background: #d1fae5;
            color: #059669;
        }

        /* Priority Indicators */
        .priority-high {
            border-left: 4px solid #ef4444;
        }

        .priority-medium {
            border-left: 4px solid #f59e0b;
        }

        .priority-low {
            border-left: 4px solid #10b981;
        }

        /* Ticket Info */
        .ticket-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 16px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .info-label {
            font-size: 12px;
            font-weight: 500;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-value {
            font-weight: 500;
            color: #2c3e50;
        }

        /* Ticket Description */
        .ticket-description {
            background: #f8fafc;
            padding: 16px;
            border-radius: 8px;
            color: #475569;
            margin-bottom: 16px;
            border-left: 3px solid #e1e8ed;
        }

        .timestamp {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 20px;
        }

        /* Ticket Actions */
        .ticket-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 10px 16px;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 14px;
        }

        .btn-primary {
            background: #4a90e2;
            color: white;
            box-shadow: 0 2px 8px rgba(74, 144, 226, 0.2);
        }

        .btn-primary:hover {
            background: #357abd;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(74, 144, 226, 0.3);
        }

        .btn-success {
            background: #a8e6cf;
            color: #2d5a3d;
            box-shadow: 0 2px 8px rgba(168, 230, 207, 0.3);
        }

        .btn-success:hover {
            background: #8dd3c7;
            transform: translateY(-1px);
        }

        .btn-danger {
            background: #fee2e2;
            color: #dc2626;
            box-shadow: 0 2px 8px rgba(220, 38, 38, 0.1);
        }

        .btn-danger:hover {
            background: #fecaca;
            transform: translateY(-1px);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 48px 24px;
            color: #64748b;
        }

        .empty-state-icon {
            font-size: 48px;
            margin-bottom: 16px;
            opacity: 0.5;
        }

        .empty-state h3 {
            font-size: 18px;
            margin-bottom: 8px;
            color: #2c3e50;
        }

        /* Logout Section */
        .logout-section {
            text-align: center;
            margin-top: 48px;
            padding-top: 32px;
            border-top: 1px solid #e1e8ed;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 16px;
                padding: 16px;
            }

            .nav-list {
                flex-wrap: wrap;
                justify-content: center;
            }

            .main-content {
                padding: 16px;
            }

            .welcome-section {
                padding: 24px 16px;
            }

            .welcome-section h1 {
                font-size: 24px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 16px;
            }

            .ticket-card {
                padding: 16px;
            }

            .ticket-info {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .ticket-actions {
                flex-direction: column;
            }

            .btn {
                justify-content: center;
            }
        }

        /* Animations */
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Notification Styles */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 16px 20px;
            border-radius: 12px;
            color: white;
            font-weight: 500;
            z-index: 10000;
            max-width: 350px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
            animation: slideIn 0.3s ease;
        }

        .notification.success {
            background: linear-gradient(135deg, #a8e6cf, #88d8a3);
        }

        .notification.error {
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
        }

        .notification.info {
            background: linear-gradient(135deg, #4a90e2, #357abd);
        }

        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <nav>
                <ul class="nav-list">
                    <li><a href="../agent/agent_dashboard.php" class="nav-link">
                        <span>🏠</span> Inicio
                    </a></li>
                    <li><a href="../create_ticket_form.php" class="nav-link">
                        <span>🎫</span> Crear Ticket
                    </a></li>
                    <li><a href="../logout.php" class="nav-link">
                        <span>🚪</span> Cerrar Sesión
                    </a></li>
                </ul>
            </nav>
            <a href="create_ticket_form.php" class="create-ticket-btn">
                <span>+</span> Nuevo Ticket
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Welcome Section -->
        <section class="welcome-section fade-in">
            <h1>👋 Bienvenido, agent@example.com</h1>
            <p>Panel de control de tickets - Gestiona y da seguimiento a todos los tickets del sistema</p>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">12</div>
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
        </section>

        <!-- Tickets Pendientes -->
        <section class="section fade-in">
            <div class="section-header">
                <span>🔔</span> Tickets Pendientes
            </div>
            <div class="tickets-container">
                <div class="ticket-grid">
                    <!-- Sample Ticket 1 -->
                    <div class="ticket-card priority-high">
                        <div class="ticket-header">
                            <div class="ticket-id">#TK-001</div>
                            <div class="ticket-status status-pending">Pendiente</div>
                        </div>
                        <div class="ticket-info">
                            <div class="info-item">
                                <div class="info-label">Usuario</div>
                                <div class="info-value">user@company.com</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Servicio</div>
                                <div class="info-value">SLA Premium</div>
                            </div>
                        </div>
                        <div class="ticket-description">
                            No puedo acceder al sistema de facturación, necesito ayuda urgente para procesar los pagos del mes.
                        </div>
                        <div class="timestamp">Creado hace 2 horas</div>
                        <div class="ticket-actions">
                            <a href="#" class="btn btn-primary">👨‍💼 Atender</a>
                        </div>
                    </div>

                    <!-- Sample Ticket 2 -->
                    <div class="ticket-card priority-medium">
                        <div class="ticket-header">
                            <div class="ticket-id">#TK-002</div>
                            <div class="ticket-status status-pending">Pendiente</div>
                        </div>
                        <div class="ticket-info">
                            <div class="info-item">
                                <div class="info-label">Usuario</div>
                                <div class="info-value">cliente@empresa.com</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Servicio</div>
                                <div class="info-value">SLA Estándar</div>
                            </div>
                        </div>
                        <div class="ticket-description">
                            Solicito capacitación sobre las nuevas funcionalidades del módulo de reportes.
                        </div>
                        <div class="timestamp">Creado hace 5 horas</div>
                        <div class="ticket-actions">
                            <a href="#" class="btn btn-primary">👨‍💼 Atender</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Mis Tickets Pendientes -->
        <section class="section fade-in">
            <div class="section-header">
                <span>👤</span> Mis Tickets Pendientes
            </div>
            <div class="tickets-container">
                <div class="ticket-grid">
                    <!-- Sample Assigned Ticket -->
                    <div class="ticket-card priority-high">
                        <div class="ticket-header">
                            <div class="ticket-id">#TK-003</div>
                            <div class="ticket-status status-assigned">Asignado</div>
                        </div>
                        <div class="ticket-info">
                            <div class="info-item">
                                <div class="info-label">Servicio</div>
                                <div class="info-value">SLA Premium</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Fecha de Creación</div>
                                <div class="info-value">2024-01-15 10:30</div>
                            </div>
                        </div>
                        <div class="ticket-description">
                            Error crítico en el servidor de base de datos, múltiples usuarios reportan lentitud extrema.
                        </div>
                        <div class="timestamp">Asignado hace 1 hora</div>
                        <div class="ticket-actions">
                            <button class="btn btn-success" onclick="finalizarTicket(3, this)">✅ Finalizar</button>
                            <a href="#" class="btn btn-primary">📝 Actualizar</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Mis Tickets Creados -->
        <section class="section fade-in">
            <div class="section-header">
                <span>📋</span> Mis Tickets Creados
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

        <!-- Logout Section -->
        <div class="logout-section">
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
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.fade-in').forEach(element => {
            observer.observe(element);
        });

        // Ticket finalization function
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
            notification.className = `notification ${type}`;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            // Trigger initial fade-in for elements in viewport
            setTimeout(() => {
                document.querySelectorAll('.fade-in').forEach(element => {
                    const rect = element.getBoundingClientRect();
                    if (rect.top < window.innerHeight) {
                        element.classList.add('visible');
                    }
                });
            }, 100);
        });
    </script>
</body>
</html>