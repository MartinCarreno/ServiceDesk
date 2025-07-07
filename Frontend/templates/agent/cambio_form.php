<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear/Editar Cambio - HelpDesk</title>
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
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            border-radius: 12px;
            box-shadow: rgba(0, 0, 0, 0.05) 0px 4px 12px;
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #4a90e2 0%, #357abd 100%);
            color: white;
            padding: 32px;
            text-align: center;
        }

        .header h1 {
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .header p {
            font-size: 16px;
            opacity: 0.9;
            font-weight: 300;
        }

        .form-container {
            padding: 40px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 24px;
        }

        @media (min-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr 1fr;
            }
            
            .form-group.full-width {
                grid-column: 1 / -1;
            }
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-size: 14px;
            font-weight: 500;
            color: #555;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 16px;
            font-family: inherit;
            transition: all 0.3s ease;
            background-color: #fafafa;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #4a90e2;
            background-color: white;
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }

        .status-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        @media (max-width: 767px) {
            .status-group {
                grid-template-columns: 1fr;
            }
        }

        .risk-indicator {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            margin-top: 4px;
        }

        .risk-low {
            background-color: #a8e6cf;
            color: #2d7a3e;
        }

        .risk-medium {
            background-color: #ffeaa7;
            color: #b8860b;
        }

        .risk-high {
            background-color: #ffb3b3;
            color: #c0392b;
        }

        .button-group {
            display: flex;
            gap: 16px;
            justify-content: flex-end;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid #e0e0e0;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            min-width: 120px;
            justify-content: center;
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

        .icon {
            width: 18px;
            height: 18px;
        }

        .form-hint {
            font-size: 12px;
            color: #888;
            margin-top: 4px;
        }

        @media (max-width: 767px) {
            .container {
                margin: 0;
                border-radius: 0;
                min-height: 100vh;
            }
            
            .header {
                padding: 24px 20px;
            }
            
            .header h1 {
                font-size: 24px;
            }
            
            .form-container {
                padding: 24px 20px;
            }
            
            .button-group {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
            }
        }

        .loading {
            opacity: 0.7;
            pointer-events: none;
        }

        .success-message {
            background-color: #a8e6cf;
            color: #2d7a3e;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Gestión de Cambios</h1>
            <p>Crear o editar solicitud de cambio</p>
        </div>
        
        <div class="form-container">
            <div class="success-message" id="successMessage">
                ✅ Cambio guardado correctamente
            </div>
            
            <form id="cambio-form" method="post" action="../includes/create_cambio.php">
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label for="titulo_cambio">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14,2 14,8 20,8"/>
                            </svg>
                            Título del Cambio
                        </label>
                        <input type="text" name="titulo_cambio" id="titulo_cambio" required placeholder="Ingresa el título del cambio">
                        <div class="form-hint">Proporciona un título descriptivo y conciso</div>
                    </div>
                    
                    <div class="form-group full-width">
                        <label for="desc_cambio">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14,2 14,8 20,8"/>
                                <line x1="16" y1="13" x2="8" y2="13"/>
                                <line x1="16" y1="17" x2="8" y2="17"/>
                                <polyline points="10,9 9,9 8,9"/>
                            </svg>
                            Descripción Detallada
                        </label>
                        <textarea name="desc_cambio" id="desc_cambio" required placeholder="Describe el cambio, justificación, impacto esperado y pasos de implementación..."></textarea>
                        <div class="form-hint">Incluye todos los detalles relevantes del cambio propuesto</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="tipo_cambio">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 11H5a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h4"/>
                                <path d="M15 11h4a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-4"/>
                                <path d="M12 5v14"/>
                                <path d="M8 5l4-4 4 4"/>
                            </svg>
                            Tipo de Cambio
                        </label>
                        <select name="tipo_cambio" id="tipo_cambio" required>
                            <option value="">Selecciona el tipo</option>
                            <option value="normal">Normal</option>
                            <option value="urgente">Urgente</option>
                            <option value="emergencia">Emergencia</option>
                            <option value="estandar">Estándar</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="fecha_cambio">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                <line x1="16" y1="2" x2="16" y2="6"/>
                                <line x1="8" y1="2" x2="8" y2="6"/>
                                <line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                            Fecha Programada
                        </label>
                        <input type="date" name="fecha_cambio" id="fecha_cambio" required>
                        <div class="form-hint">Fecha estimada de implementación</div>
                    </div>
                    
                    <div class="status-group">
                        <div class="form-group">
                            <label for="riesgo_cambio">
                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                                    <line x1="12" y1="9" x2="12" y2="13"/>
                                    <line x1="12" y1="17" x2="12.01" y2="17"/>
                                </svg>
                                Nivel de Riesgo
                            </label>
                            <select name="riesgo_cambio" id="riesgo_cambio" required>
                                <option value="">Selecciona el riesgo</option>
                                <option value="bajo">Bajo</option>
                                <option value="medio">Medio</option>
                                <option value="alto">Alto</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="estado_cambio">
                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                    <polyline points="22,4 12,14.01 9,11.01"/>
                                </svg>
                                Estado Actual
                            </label>
                            <select name="estado_cambio" id="estado_cambio" required>
                                <option value="">Selecciona el estado</option>
                                <option value="borrador">Borrador</option>
                                <option value="pendiente">Pendiente Aprobación</option>
                                <option value="aprobado">Aprobado</option>
                                <option value="en_progreso">En Progreso</option>
                                <option value="completado">Completado</option>
                                <option value="rechazado">Rechazado</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="button-group">
                    <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M19 12H5"/>
                            <path d="M12 19l-7-7 7-7"/>
                        </svg>
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/>
                        </svg>
                        Guardar Cambio
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Indicador visual de riesgo
        document.getElementById('riesgo_cambio').addEventListener('change', function() {
            const riesgoValue = this.value;
            const existingIndicator = document.querySelector('.risk-indicator');
            if (existingIndicator) {
                existingIndicator.remove();
            }
            
            if (riesgoValue) {
                const indicator = document.createElement('div');
                indicator.className = `risk-indicator risk-${riesgoValue}`;
                
                const icons = {
                    bajo: '🟢',
                    medio: '🟡',
                    alto: '🔴'
                };
                
                const labels = {
                    bajo: 'Riesgo Bajo - Impacto mínimo',
                    medio: 'Riesgo Medio - Requiere precaución',
                    alto: 'Riesgo Alto - Necesita aprobación especial'
                };
                
                indicator.innerHTML = `${icons[riesgoValue]} ${labels[riesgoValue]}`;
                this.parentNode.appendChild(indicator);
            }
        });

        // Validación del formulario y efecto de envío
        document.getElementById('cambio-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const form = this;
            const submitBtn = form.querySelector('.btn-primary');
            const successMessage = document.getElementById('successMessage');
            
            // Efecto de carga
            submitBtn.innerHTML = `
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"/>
                </svg>
                Guardando...
            `;
            submitBtn.disabled = true;
            form.classList.add('loading');
            
            // Simulación de envío (reemplaza con tu lógica real)
            setTimeout(() => {
                successMessage.style.display = 'block';
                successMessage.scrollIntoView({ behavior: 'smooth' });
                
                submitBtn.innerHTML = `
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 6L9 17l-5-5"/>
                    </svg>
                    Guardado
                `;
                form.classList.remove('loading');
                
                // Restaurar botón después de 2 segundos
                setTimeout(() => {
                    submitBtn.innerHTML = `
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/>
                        </svg>
                        Guardar Cambio
                    `;
                    submitBtn.disabled = false;
                }, 2000);
            }, 1500);
        });

        // Autoajuste del campo de fecha
        const fechaInput = document.getElementById('fecha_cambio');
        const today = new Date().toISOString().split('T')[0];
        fechaInput.setAttribute('min', today);
    </script>
</body>
</html>