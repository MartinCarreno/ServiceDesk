<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Cambio - HelpDesk</title>
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
            color: #333;
            line-height: 1.6;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .header {
            background: linear-gradient(135deg, #4a90e2 0%, #357abd 100%);
            color: white;
            padding: 32px;
            border-radius: 12px;
            margin-bottom: 24px;
            box-shadow: rgba(0, 0, 0, 0.05) 0px 4px 12px;
        }

        .header h1 {
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header p {
            font-size: 16px;
            opacity: 0.9;
            font-weight: 300;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            margin-bottom: 8px;
            opacity: 0.8;
        }

        .breadcrumb a {
            color: white;
            text-decoration: none;
            transition: opacity 0.3s ease;
        }

        .breadcrumb a:hover {
            opacity: 0.8;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
            margin-bottom: 24px;
        }

        @media (max-width: 768px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
        }

        .card {
            background: white;
            border-radius: 12px;
            box-shadow: rgba(0, 0, 0, 0.05) 0px 4px 12px;
            overflow: hidden;
        }

        .card-header {
            padding: 20px 24px;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .card-header h2 {
            font-size: 18px;
            font-weight: 600;
            color: #333;
        }

        .card-content {
            padding: 24px;
        }

        .detail-item {
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid #f0f0f0;
        }

        .detail-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .detail-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 500;
            color: #666;
            margin-bottom: 6px;
        }

        .detail-value {
            font-size: 16px;
            color: #333;
            font-weight: 400;
        }

        .detail-description {
            background-color: #fafafa;
            padding: 16px;
            border-radius: 8px;
            border-left: 4px solid #4a90e2;
            white-space: pre-wrap;
            line-height: 1.7;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-borrador {
            background-color: #f8f9fa;
            color: #6c757d;
        }

        .status-pendiente {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-aprobado {
            background-color: #a8e6cf;
            color: #2d7a3e;
        }

        .status-en_progreso {
            background-color: #cce5ff;
            color: #0056b3;
        }

        .status-completado {
            background-color: #a8e6cf;
            color: #155724;
        }

        .status-rechazado {
            background-color: #f8d7da;
            color: #721c24;
        }

        .risk-indicator {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .risk-bajo {
            background-color: #a8e6cf;
            color: #2d7a3e;
        }

        .risk-medio {
            background-color: #ffeaa7;
            color: #b8860b;
        }

        .risk-alto {
            background-color: #ffb3b3;
            color: #c0392b;
        }

        .type-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            background-color: #e3f2fd;
            color: #1976d2;
            text-transform: capitalize;
        }

        .action-buttons {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            text-align: center;
            justify-content: center;
            min-width: 120px;
        }

        .btn-primary {
            background-color: #4a90e2;
            color: white;
            box-shadow: rgba(74, 144, 226, 0.3) 0px 4px 12px;
        }

        .btn-primary:hover {
            background-color: #357abd;
            transform: translateY(-2px);
            box-shadow: rgba(74, 144, 226, 0.4) 0px 6px 16px;
        }

        .btn-secondary {
            background-color: #f8f9fa;
            color: #6c757d;
            border: 2px solid #e0e0e0;
        }

        .btn-secondary:hover {
            background-color: #e9ecef;
            transform: translateY(-1px);
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
            box-shadow: rgba(220, 53, 69, 0.3) 0px 4px 12px;
        }

        .btn-danger:hover {
            background-color: #c82333;
            transform: translateY(-2px);
            box-shadow: rgba(220, 53, 69, 0.4) 0px 6px 16px;
        }

        .btn-success {
            background-color: #28a745;
            color: white;
            box-shadow: rgba(40, 167, 69, 0.3) 0px 4px 12px;
        }

        .btn-success:hover {
            background-color: #218838;
            transform: translateY(-2px);
            box-shadow: rgba(40, 167, 69, 0.4) 0px 6px 16px;
        }

        .icon {
            width: 16px;
            height: 16px;
        }

        .timeline {
            position: relative;
            padding-left: 32px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 12px;
            top: 0;
            bottom: 0;
            width: 2px;
            background-color: #e0e0e0;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 20px;
            padding: 16px;
            background-color: #fafafa;
            border-radius: 8px;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -26px;
            top: 20px;
            width: 8px;
            height: 8px;
            background-color: #4a90e2;
            border-radius: 50%;
            border: 2px solid white;
        }

        .timeline-date {
            font-size: 12px;
            color: #666;
            font-weight: 500;
        }

        .timeline-content {
            font-size: 14px;
            color: #333;
            margin-top: 4px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-top: 16px;
        }

        .info-item {
            background-color: #f8f9fa;
            padding: 12px 16px;
            border-radius: 8px;
            border-left: 4px solid #4a90e2;
        }

        .info-item-label {
            font-size: 12px;
            color: #666;
            font-weight: 500;
            margin-bottom: 4px;
        }

        .info-item-value {
            font-size: 14px;
            color: #333;
            font-weight: 400;
        }

        .loading {
            text-align: center;
            padding: 40px;
            color: #666;
        }

        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #4a90e2;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 16px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @media (max-width: 768px) {
            .header {
                padding: 20px;
            }
            
            .header h1 {
                font-size: 24px;
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }
            
            .card-content {
                padding: 16px;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="breadcrumb">
                <a href="../dashboard.php">Dashboard</a>
                <span>›</span>
                <a href="../cambios.php">Cambios</a>
                <span>›</span>
                <span>Detalle</span>
            </div>
            <h1>
                <svg class="icon" style="width: 32px; height: 32px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14,2 14,8 20,8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                </svg>
                Detalle del Cambio
            </h1>
            <p>Información completa y seguimiento del cambio</p>
        </div>

        <div class="content-grid">
            <div class="card">
                <div class="card-header">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14,2 14,8 20,8"/>
                    </svg>
                    <h2>Información del Cambio</h2>
                </div>
                <div class="card-content" id="cambio-detalle">
                    <div class="loading">
                        <div class="loading-spinner"></div>
                        <p>Cargando información del cambio...</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="3"/>
                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1 1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                    </svg>
                    <h2>Acciones</h2>
                </div>
                <div class="card-content">
                    <div class="action-buttons">
                        <a href="../cambio_edit.php?id=123" class="btn btn-primary">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                            </svg>
                            Editar
                        </a>
                        <button class="btn btn-success" onclick="aprobarCambio()">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 6L9 17l-5-5"/>
                            </svg>
                            Aprobar
                        </button>
                        <button class="btn btn-danger" onclick="rechazarCambio()">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="18" y1="6" x2="6" y2="18"/>
                                <line x1="6" y1="6" x2="18" y2="18"/>
                            </svg>
                            Rechazar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                </svg>
                <h2>Historial de Cambios</h2>
            </div>
            <div class="card-content">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-date">15 de Junio, 2024 - 10:30 AM</div>
                        <div class="timeline-content">Cambio creado por Juan Pérez</div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-date">15 de Junio, 2024 - 02:15 PM</div>
                        <div class="timeline-content">Cambio enviado para revisión</div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-date">16 de Junio, 2024 - 09:45 AM</div>
                        <div class="timeline-content">Cambio aprobado por María González</div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-date">16 de Junio, 2024 - 11:20 AM</div>
                        <div class="timeline-content">Implementación iniciada</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Datos de ejemplo del cambio - En producción, estos vendrían del servidor
        const cambioData = {
            id: 'CHG-2024-001',
            titulo: 'Actualización del Sistema de Autenticación',
            descripcion: 'Migración del sistema de autenticación actual a OAuth 2.0 para mejorar la seguridad y experiencia del usuario. Este cambio incluye:\n\n• Implementación de OAuth 2.0\n• Migración de usuarios existentes\n• Actualización de la interfaz de login\n• Pruebas de seguridad\n• Documentación técnica actualizada',
            tipo: 'normal',
            fecha: '2024-06-20',
            riesgo: 'medio',
            estado: 'aprobado',
            solicitante: 'Juan Pérez',
            aprobador: 'María González',
            fechaCreacion: '2024-06-15',
            fechaAprobacion: '2024-06-16',
            categoria: 'Seguridad',
            prioridad: 'Alta',
            impacto: 'Todos los usuarios del sistema',
            tiempoEstimado: '4 horas'
        };

        function cargarDetalleCambio() {
            const contenedor = document.getElementById('cambio-detalle');
            
            // Simulación de carga
            setTimeout(() => {
                contenedor.innerHTML = `
                    <div class="detail-item">
                        <div class="detail-label">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14,2 14,8 20,8"/>
                            </svg>
                            ID del Cambio
                        </div>
                        <div class="detail-value">${cambioData.id}</div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14,2 14,8 20,8"/>
                                <line x1="16" y1="13" x2="8" y2="13"/>
                                <line x1="16" y1="17" x2="8" y2="17"/>
                            </svg>
                            Título del Cambio
                        </div>
                        <div class="detail-value">${cambioData.titulo}</div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14,2 14,8 20,8"/>
                                <line x1="16" y1="13" x2="8" y2="13"/>
                                <line x1="16" y1="17" x2="8" y2="17"/>
                                <polyline points="10,9 9,9 8,9"/>
                            </svg>
                            Descripción
                        </div>
                        <div class="detail-value">
                            <div class="detail-description">${cambioData.descripcion}</div>
                        </div>
                    </div>

                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-item-label">Tipo</div>
                            <div class="info-item-value">
                                <span class="type-badge">
                                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M9 11H5a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h4"/>
                                        <path d="M15 11h4a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-4"/>
                                        <path d="M12 5v14"/>
                                        <path d="M8 5l4-4 4 4"/>
                                    </svg>
                                    ${cambioData.tipo}
                                </span>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-item-label">Estado</div>
                            <div class="info-item-value">
                                <span class="status-badge status-${cambioData.estado}">
                                    ${getStatusIcon(cambioData.estado)}
                                    ${getStatusText(cambioData.estado)}
                                </span>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-item-label">Nivel de Riesgo</div>
                            <div class="info-item-value">
                                <span class="risk-indicator risk-${cambioData.riesgo}">
                                    ${getRiskIcon(cambioData.riesgo)}
                                    ${getRiskText(cambioData.riesgo)}
                                </span>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-item-label">Fecha Programada</div>
                            <div class="info-item-value">${formatDate(cambioData.fecha)}</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-item-label">Solicitante</div>
                            <div class="info-item-value">${cambioData.solicitante}</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-item-label">Aprobador</div>
                            <div class="info-item-value">${cambioData.aprobador}</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-item-label">Categoría</div>
                            <div class="info-item-value">${cambioData.categoria}</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-item-label">Prioridad</div>
                            <div class="info-item-value">${cambioData.prioridad}</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-item-label">Impacto</div>
                            <div class="info-item-value">${cambioData.impacto}</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-item-label">Tiempo Estimado</div>
                            <div class="info-item-value">${cambioData.tiempoEstimado}</div>
                        </div>
                    </div>
                `;
            }, 1000);
        }

        function getStatusIcon(estado) {
            const icons = {
                'borrador': '📝',
                'pendiente': '⏳',
                'aprobado': '✅',
                'en_progreso': '🔄',
                'completado': '✅',
                'rechazado': '❌'
            };
            return icons[estado] || '📋';
        }

        function getStatusText(estado) {
            const texts = {
                'borrador': 'Borrador',
                'pendiente': 'Pendiente',
                'aprobado': 'Aprobado',
                'en_progreso': 'En Progreso',
                'completado': 'Completado',
                'rechazado': 'Rechazado'
            };
            return texts[estado] || estado;
        }

        function getRiskIcon(riesgo) {
            const icons = {
                'bajo': '🟢',
                'medio': '🟡',
                'alto': '🔴'
            };
            return icons[riesgo] || '⚪';
        }

        function getRiskText(riesgo) {
            const texts = {
                'bajo': 'Bajo',
                'medio': 'Medio',
                'alto': 'Alto'
            };
            return texts[riesgo] || riesgo;
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('es-ES', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        }

        function aprobarCambio() {
            if (confirm('¿Estás seguro de que deseas aprobar este cambio?')) {
                // Aquí iría la lógica para aprobar el cambio
                alert('Cambio aprobado exitosamente');
                // Actualizar el estado en la interfaz
                cambioData.estado = 'aprobado';
                cargarDetalleCambio();
            }
        }

        function rechazarCambio() {
            const motivo = prompt('Por favor, indica el motivo del rechazo:');
            if (motivo) {
                // Aquí iría la lógica para rechazar el cambio
                alert('Cambio rechazado. Motivo: ' + motivo);
                // Actualizar el estado en la interfaz
                cambioData.estado = 'rech