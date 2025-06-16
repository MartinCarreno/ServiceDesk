<?php
include '../includes/session_validation.php'; // Validar sesión

// Obtener categorías principales desde el backend
$url = 'http://localhost:3000/api/categories';
$response = @file_get_contents($url);
$categorias = $response ? json_decode($response, true) : [];

// Mostrar errores si existen
$error = $_SESSION['error'] ?? null;
unset($_SESSION['error']); // Limpiar el error después de mostrarlo
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/app.css">
    <title>Crear Ticket</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: 300;
            margin-bottom: 10px;
        }

        .header p {
            opacity: 0.9;
            font-size: 1.1rem;
        }

        .form-container {
            padding: 40px;
        }

        .error-message {
            background: #fee;
            color: #c33;
            padding: 15px;
            border-radius: 10px;
            border-left: 4px solid #c33;
            margin-bottom: 25px;
            font-weight: 500;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2c3e50;
            font-size: 1rem;
        }

        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e6ed;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        .form-group textarea {
            min-height: 120px;
            resize: vertical;
            font-family: inherit;
        }

        .radio-group {
            display: flex;
            gap: 20px;
            margin-top: 8px;
        }

        .radio-option {
            display: flex;
            align-items: center;
            cursor: pointer;
            padding: 10px 15px;
            border: 2px solid #e0e6ed;
            border-radius: 10px;
            transition: all 0.3s ease;
            background: white;
        }

        .radio-option:hover {
            border-color: #3498db;
            background: #f8f9fa;
        }

        .radio-option input[type="radio"] {
            margin-right: 8px;
            transform: scale(1.2);
        }

        .radio-option input[type="radio"]:checked + .radio-label {
            color: #3498db;
            font-weight: 600;
        }

        .radio-option:has(input:checked) {
            border-color: #3498db;
            background: #f0f8ff;
        }

        .hidden {
            display: none;
        }

        .service-container {
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }

        .service-container.show {
            opacity: 1;
            transform: translateY(0);
        }

        .button-group {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            min-width: 120px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(52, 152, 219, 0.3);
        }

        .btn-secondary {
            background: #ecf0f1;
            color: #2c3e50;
            border: 2px solid #bdc3c7;
        }

        .btn-secondary:hover {
            background: #d5dbdb;
            border-color: #95a5a6;
        }

        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid #3498db;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        @media (max-width: 768px) {
            .container {
                margin: 10px;
                border-radius: 10px;
            }

            .header {
                padding: 20px;
            }

            .header h1 {
                font-size: 2rem;
            }

            .form-container {
                padding: 20px;
            }

            .radio-group {
                flex-direction: column;
                gap: 10px;
            }

            .button-group {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
    <script>
        async function cargarServicios() {
            const categoriaId = document.getElementById('categoria').value;
            const tipoTicket = document.querySelector('input[name="tipo_ticket"]:checked')?.value;

            if (!categoriaId || !tipoTicket) {
                alert('Por favor, seleccione una categoría y un tipo de ticket.');
                return;
            }

            // Mostrar loading
            const servicioContainer = document.getElementById('servicio-container');
            const servicioSelect = document.getElementById('servicio');
            servicioSelect.classList.add('loading');

            try {
                // Obtener servicios desde el backend
                const response = await fetch(`http://localhost:3000/api/services/category/${categoriaId}`);
                const servicios = await response.json();

                // Limpiar el dropdown de servicios
                servicioSelect.innerHTML = '<option value="">Seleccione un servicio</option>';

                // Agregar los servicios al dropdown
                servicios.forEach(servicio => {
                    const option = document.createElement('option');
                    option.value = servicio.id_servicio;
                    option.textContent = servicio.nom_servicio;
                    servicioSelect.appendChild(option);
                });

                // Mostrar el dropdown de servicios con animación
                servicioContainer.classList.remove('hidden');
                setTimeout(() => {
                    servicioContainer.classList.add('show');
                }, 10);

            } catch (error) {
                console.error('Error al cargar servicios:', error);
                alert('Error al cargar los servicios. Por favor, intente nuevamente.');
            } finally {
                servicioSelect.classList.remove('loading');
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Crear Ticket</h1>
            <p>Complete el formulario para crear un nuevo ticket de soporte</p>
        </div>

        <div class="form-container">
            <?php if ($error): ?>
                <div class="error-message">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form action="../includes/create_ticket.php" method="POST">
                <!-- Selección de categoría -->
                <div class="form-group">
                    <label for="categoria">Categoría:</label>
                    <select id="categoria" name="categoria" required>
                        <option value="">Seleccione una categoría</option>
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?php echo htmlspecialchars($categoria['id_categoria']); ?>">
                                <?php echo htmlspecialchars($categoria['nom_categoria']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Selección del tipo de ticket -->
                <div class="form-group">
                    <label>Tipo de Ticket:</label>
                    <div class="radio-group">
                        <label class="radio-option">
                            <input type="radio" name="tipo_ticket" value="incidente" onclick="cargarServicios()">
                            <span class="radio-label">Incidente</span>
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="tipo_ticket" value="solicitud" onclick="cargarServicios()">
                            <span class="radio-label">Solicitud</span>
                        </label>
                    </div>
                </div>

                <!-- Selección de servicio -->
                <div id="servicio-container" class="form-group service-container hidden">
                    <label for="servicio">Servicio:</label>
                    <select id="servicio" name="servicio" required>
                        <option value="">Seleccione un servicio</option>
                    </select>
                </div>

                <!-- Descripción del ticket -->
                <div class="form-group">
                    <label for="descripcion">Descripción:</label>
                    <textarea id="descripcion" name="descripcion" placeholder="Describa detalladamente su solicitud o incidente..." required></textarea>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">Crear Ticket</button>
                    <a href="javascript:history.back()" class="btn btn-secondary">Volver</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>