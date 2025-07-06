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
    <script>
        // Mostrar el selector de tipo de ticket solo si hay categoría seleccionada
        function cargarTicketTipo() {
            const categoriaId = document.getElementById('categoria').value;
            const ticketContainer = document.getElementById('ticket-container');
            const servicioContainer = document.getElementById('servicio-container');
            // Oculta el selector de servicio y resetea su valor
            servicioContainer.classList.add('hidden');
            servicioContainer.classList.remove('show');
            document.getElementById('servicio').innerHTML = '<option value="">Seleccione un servicio</option>';

            if (categoriaId) {
                ticketContainer.classList.remove('hidden');
            } else {
                ticketContainer.classList.add('hidden');
                // Limpia selección de tipo de ticket
                document.querySelectorAll('input[name="tipo_ticket"]').forEach(radio => radio.checked = false);
            }
        }

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

<body class="ticket-form">
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
                    <select id="categoria" name="categoria" required onchange="cargarTicketTipo()">
                        <option value="">Seleccione una categoría</option>
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?php echo htmlspecialchars($categoria['id_categoria']); ?>">
                                <?php echo htmlspecialchars($categoria['nom_categoria']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Selección del tipo de ticket -->
                <div id="ticket-container" class="form-group hidden">
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