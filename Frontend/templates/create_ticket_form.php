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
        async function cargarServicios() {
            const categoriaId = document.getElementById('categoria').value;
            const tipoTicket = document.querySelector('input[name="tipo_ticket"]:checked')?.value;

            if (!categoriaId || !tipoTicket) {
                alert('Por favor, seleccione una categoría y un tipo de ticket.');
                return;
            }

            // Obtener servicios desde el backend
            const response = await fetch(`http://localhost:3000/api/services/category/${categoriaId}`);
            const servicios = await response.json();

            // Limpiar el dropdown de servicios
            const servicioSelect = document.getElementById('servicio');
            servicioSelect.innerHTML = '<option value="">Seleccione un servicio</option>';

            // Agregar los servicios al dropdown
            servicios.forEach(servicio => {
                const option = document.createElement('option');
                option.value = servicio.id_servicio;
                option.textContent = servicio.nom_servicio;
                servicioSelect.appendChild(option);
            });

            // Mostrar el dropdown de servicios
            document.getElementById('servicio-container').style.display = 'block';
        }
    </script>
</head>
<body>
    
    <h1>Crear Ticket</h1>

    <?php if ($error): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form action="../includes/create_ticket.php" method="POST">
        <!-- Selección de categoría -->
        <label for="categoria">Categoría:</label>
        <select id="categoria" name="categoria" required>
            <option value="">Seleccione una categoría</option>
            <?php foreach ($categorias as $categoria): ?>
                <option value="<?php echo htmlspecialchars($categoria['id_categoria']); ?>">
                    <?php echo htmlspecialchars($categoria['nom_categoria']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <!-- Selección del tipo de ticket -->
        <label>Tipo de Ticket:</label>
        <label>
            <input type="radio" name="tipo_ticket" value="incidente" onclick="cargarServicios()"> Incidente
        </label>
        <label>
            <input type="radio" name="tipo_ticket" value="solicitud" onclick="cargarServicios()"> Solicitud
        </label>
        <br><br>

        <!-- Selección de servicio -->
        <div id="servicio-container" style="display: none;">
            <label for="servicio">Servicio:</label>
            <select id="servicio" name="servicio" required>
                <option value="">Seleccione un servicio</option>
            </select>
        </div>
        <br><br>

        <!-- Descripción del ticket -->
        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required></textarea>
        <br><br>

        <button type="submit">Crear Ticket</button>
    </form>
    
    <br><br>
    <a href="javascript:history.back()">
        <button type="button">Volver</button>
    </a>
    
</body>
</html>