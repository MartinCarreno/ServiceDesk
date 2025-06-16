<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Agente - Tickets</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 1rem 2rem;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar ul {
            list-style: none;
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .navbar a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .navbar a:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }

        .header-actions {
            position: fixed;
            top: 100px;
            right: 2rem;
            z-index: 999;
        }

        .create-btn {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(45deg, #ff6b6b, #ee5a52);
            border: none;
            color: white;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 4px 20px rgba(255, 107, 107, 0.4);
            transition: all 0.3s ease;
        }

        .create-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 25px rgba(255, 107, 107, 0.6);
        }

        .main-content {
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .welcome-section {
            background: rgba(255, 255, 255, 0.95);
            padding: 2rem;
            border-radius: 20px;
            margin-bottom: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .welcome-section h1 {
            color: #333;
            margin-bottom: 1rem;
            font-size: 2rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin: 2rem 0;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 1.5rem;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #667eea;
        }

        .stat-label {
            color: #666;
            margin-top: 0.5rem;
        }

        .section {
            background: rgba(255, 255, 255, 0.95);
            margin: 2rem 0;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .section-header {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 1.5rem 2rem;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .tickets-container {
            padding: 2rem;
        }

        .ticket-grid {
            display: grid;
            gap: 1rem;
        }

        .ticket-card {
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 15px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .ticket-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .ticket-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .ticket-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .ticket-id {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .ticket-status {
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .status-assigned {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #74c0fc;
        }

        .status-completed {
            background: #d4edda;
            color: #155724;
            border: 1px solid #55a3ff;
        }

        .ticket-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin: 1rem 0;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-size: 0.8rem;
            color: #666;
            margin-bottom: 0.3rem;
            text-transform: uppercase;
            font-weight: 600;
        }

        .info-value {
            font-weight: 500;
            color: #333;
        }

        .ticket-description {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 10px;
            margin: 1rem 0;
            font-style: italic;
            color: #555;
        }

        .ticket-actions {
            display: flex;
            gap: 0.5rem;
            justify-content: flex-end;
            margin-top: 1rem;
        }

        .btn {
            padding: 0.6rem 1.2rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-success {
            background: linear-gradient(135deg, #51cf66, #40c057);
            color: white;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(81, 207, 102, 0.4);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
            color: white;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.4);
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #666;
        }

        .empty-state-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.3;
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
            }

            .navbar {
                padding: 1rem;
            }

            .navbar ul {
                flex-direction: column;
                gap: 1rem;
            }

            .ticket-info {
                grid-template-columns: 1fr;
            }

            .ticket-actions {
                flex-direction: column;
            }

            .header-actions {
                position: relative;
                top: auto;
                right: auto;
                margin: 1rem 0;
                text-align: center;
            }
        }

        .priority-high {
            border-left-color: #ff6b6b !important;
        }

        .priority-medium {
            border-left-color: #ffd43b !important;
        }

        .priority-low {
            border-left-color: #51cf66 !important;
        }

        .timestamp {
            font-size: 0.8rem;
            color: #999;
            margin-top: 0.5rem;
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <ul>
            <li><a href="agent_dashboard.php">🏠 Inicio</a></li>
            <li><a href="create_ticket_form.php">🎫 Crear Ticket</a></li>
            <li><a href="logout.php">🚪 Cerrar Sesión</a></li>
        </ul>
    </nav>
    
    <div class="header-actions">
        <a href="create_ticket_form.php">
            <button class="create-btn" title="Crear Nuevo Ticket">+</button>
        </a>
    </div>

    <main class="main-content">
        <div class="welcome-section fade-in">
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
        </div>

        <!-- Tickets Pendientes -->
        <section class="section fade-in">
            <div class="section-header">
                🔔 Tickets Pendientes
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
                👤 Mis Tickets Pendientes
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