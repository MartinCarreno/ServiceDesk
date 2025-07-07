<?php
// Plantilla para mostrar el listado de cambios
// Aquí se incluirá la tabla/lista de cambios obtenidos desde la API
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Cambios - HelpDesk</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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
            font-size: 16px;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header */
        .header {
            background: white;
            border-radius: 12px;
            box-shadow: rgba(0, 0, 0, 0.05) 0px 4px 12px;
            padding: 30px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        h1 {
            font-size: 32px;
            font-weight: 600;
            color: #333;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        h1::before {
            content: '📋';
            font-size: 28px;
        }

        /* Filter Controls */
        .filter-controls {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            align-items: center;
        }

        .filter-btn {
            padding: 8px 16px;
            border: 2px solid #e5e5e5;
            border-radius: 12px;
            background: white;
            color: #666;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .filter-btn:hover {
            border-color: #4a90e2;
            color: #4a90e2;
            background: #f8fbff;
        }

        .filter-btn.active {
            background: #4a90e2;
            color: white;
            border-color: #4a90e2;
        }

        .refresh-btn {
            padding: 10px 20px;
            background: #a8e6cf;
            color: #2d5a3d;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: rgba(0, 0, 0, 0.05) 0px 2px 8px;
        }

        .refresh-btn:hover {
            background: #9dd9c3;
            transform: translateY(-1px);
            box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;
        }

        /* Main Content */
        .main-content {
            background: white;
            border-radius: 12px;
            box-shadow: rgba(0, 0, 0, 0.05) 0px 4px 12px;
            overflow: hidden;
        }

        /* Stats Bar */
        .stats-bar {
            background: #fafafa;
            padding: 16px 30px;
            border-bottom: 1px solid #e5e5e5;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }

        .stats-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #666;
        }

        .stats-value {
            font-weight: 600;
            color: #333;
        }

        /* Cambios List */
        #cambios-list {
            padding: 30px;
        }

        .cambio-item {
            border: 1px solid #e5e5e5;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 16px;
            background: white;
            transition: all 0.2s ease;
            position: relative;
        }

        .cambio-item:hover {
            box-shadow: rgba(0, 0, 0, 0.05) 0px 4px 12px;
            transform: translateY(-1px);
        }

        .cambio-item:last-child {
            margin-bottom: 0;
        }

        .cambio-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .cambio-id {
            font-size: 18px;
            font-weight: 600;
            color: #333;
        }

        .cambio-status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-approved {
            background: #d4edda;
            color: #155724;
        }

        .status-rejected {
            background: #f8d7da;
            color: #721c24;
        }

        .status-implemented {
            background: #cce5ff;
            color: #004085;
        }

        .cambio-description {
            color: #666;
            margin-bottom: 16px;
            line-height: 1.5;
        }

        .cambio-meta {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            font-size: 14px;
            color: #888;
        }

        .cambio-meta-item {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .cambio-meta-item::before {
            content: attr(data-icon);
            font-size: 16px;
        }

        .cambio-priority {
            position: absolute;
            top: 0;
            right: 0;
            width: 4px;
            height: 100%;
            border-radius: 0 12px 12px 0;
        }

        .priority-high {
            background: #dc3545;
        }

        .priority-medium {
            background: #ffc107;
        }

        .priority-low {
            background: #28a745;
        }

        /* Loading State */
        .loading {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }

        .loading::before {
            content: '⏳';
            font-size: 48px;
            display: block;
            margin-bottom: 16px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }

        .empty-state::before {
            content: '📋';
            font-size: 48px;
            display: block;
            margin-bottom: 16px;
            opacity: 0.5;
        }

        .empty-title {
            font-size: 20px;
            font-weight: 500;
            margin-bottom: 8px;
            color: #333;
        }

        .empty-text {
            font-size: 16px;
            color: #666;
        }

        /* Search Box */
        .search-box {
            position: relative;
            margin-bottom: 20px;
        }

        .search-input {
            width: 100%;
            padding: 12px 16px 12px 44px;
            border: 2px solid #e5e5e5;
            border-radius: 12px;
            font-size: 16px;
            font-family: inherit;
            background: white;
            transition: all 0.2s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: #4a90e2;
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 18px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            .header {
                padding: 20px;
                flex-direction: column;
                text-align: center;
            }

            h1 {
                font-size: 24px;
            }

            .filter-controls {
                justify-content: center;
            }

            .main-content {
                margin-top: 20px;
            }

            .stats-bar {
                padding: 16px 20px;
                flex-direction: column;
                gap: 8px;
            }

            #cambios-list {
                padding: 20px;
            }

            .cambio-item {
                padding: 16px;
            }

            .cambio-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .cambio-meta {
                flex-direction: column;
                gap: 8px;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 10px;
            }

            .header {
                padding: 15px;
            }

            h1 {
                font-size: 20px;
            }

            .filter-controls {
                width: 100%;
                justify-content: stretch;
            }

            .filter-btn {
                flex: 1;
                justify-content: center;
            }

            #cambios-list {
                padding: 15px;
            }

            .cambio-item {
                padding: 12px;
            }

            .cambio-id {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header class="header">
            <h1>Listado de Cambios</h1>
            <div class="filter-controls">
                <a href="#" class="filter-btn active" data-filter="all">
                    <span>📋</span> Todos
                </a>
                <a href="#" class="filter-btn" data-filter="pending">
                    <span>⏳</span> Pendientes
                </a>
                <a href="#" class="filter-btn" data-filter="approved">
                    <span>✅</span> Aprobados
                </a>
                <a href="#" class="filter-btn" data-filter="implemented">
                    <span>🚀</span> Implementados
                </a>
                <button class="refresh-btn" onclick="loadCambios()">
                    <span>🔄</span> Actualizar
                </button>
            </div>
        </header>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Stats Bar -->
            <div class="stats-bar">
                <div class="stats-item">
                    <span>📊</span>
                    <span>Total: <span class="stats-value" id="total-count">0</span></span>
                </div>
                <div class="stats-item">
                    <span>⏳</span>
                    <span>Pendientes: <span class="stats-value" id="pending-count">0</span></span>
                </div>
                <div class="stats-item">
                    <span>✅</span>
                    <span>Aprobados: <span class="stats-value" id="approved-count">0</span></span>
                </div>
                <div class="stats-item">
                    <span>🚀</span>
                    <span>Implementados: <span class="stats-value" id="implemented-count">0</span></span>
                </div>
            </div>

            <!-- Search Box -->
            <div class="search-box" style="margin: 20px 30px;">
                <span class="search-icon">🔍</span>
                <input type="text" class="search-input" placeholder="Buscar cambios..." id="search-input">
            </div>

            <!-- Cambios List -->
            <div id="cambios-list">
                <!-- Loading State -->
                <div class="loading" id="loading-state">
                    <h3>Cargando cambios...</h3>
                    <p>Por favor espera mientras obtenemos la información</p>
                </div>

                <!-- Empty State -->
                <div class="empty-state" id="empty-state" style="display: none;">
                    <h3 class="empty-title">No hay cambios disponibles</h3>
                    <p class="empty-text">No se encontraron cambios en el sistema</p>
                </div>

                <!-- Example Cambio Items (estos serían generados dinámicamente) -->
                <div class="cambio-item" style="display: none;">
                    <div class="cambio-priority priority-high"></div>
                    <div class="cambio-header">
                        <div class="cambio-id">CHG-001</div>
                        <div class="cambio-status status-pending">Pendiente</div>
                    </div>
                    <div class="cambio-description">
                        Actualización del sistema de autenticación para mejorar la seguridad
                    </div>
                    <div class="cambio-meta">
                        <div class="cambio-meta-item" data-icon="👤">
                            <span>Solicitado por: Juan Pérez</span>
                        </div>
                        <div class="cambio-meta-item" data-icon="📅">
                            <span>Fecha: 15/03/2024</span>
                        </div>
                        <div class="cambio-meta-item" data-icon="⚡">
                            <span>Prioridad: Alta</span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Función para cargar cambios (placeholder)
        function loadCambios() {
            console.log('Cargando cambios...');
            // Aquí iría la llamada a la API
            
            // Simular carga
            document.getElementById('loading-state').style.display = 'block';
            document.getElementById('empty-state').style.display = 'none';
            
            // Simular respuesta después de 2 segundos
            setTimeout(() => {
                document.getElementById('loading-state').style.display = 'none';
                // Aquí se procesarían los datos de la API
                updateStats(0, 0, 0, 0); // Valores de ejemplo
                
                // Si no hay cambios, mostrar estado vacío
                document.getElementById('empty-state').style.display = 'block';
            }, 2000);
        }

        // Función para actualizar estadísticas
        function updateStats(total, pending, approved, implemented) {
            document.getElementById('total-count').textContent = total;
            document.getElementById('pending-count').textContent = pending;
            document.getElementById('approved-count').textContent = approved;
            document.getElementById('implemented-count').textContent = implemented;
        }

        // Filtros
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remover active de todos
                document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                
                // Añadir active al clickeado
                this.classList.add('active');
                
                const filter = this.getAttribute('data-filter');
                console.log('Filtrar por:', filter);
                // Aquí iría la lógica de filtrado
            });
        });

        // Búsqueda
        document.getElementById('search-input').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            console.log('Buscar:', searchTerm);
            // Aquí iría la lógica de búsqueda
        });

        // Cargar cambios al iniciar
        document.addEventListener('DOMContentLoaded', function() {
            loadCambios();
        });
    </script>
</body>
</html>