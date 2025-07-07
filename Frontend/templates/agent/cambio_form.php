<?php include '../../includes/session_validation.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Cambio</title>
    <link rel="stylesheet" href="../../assets/css/app.css">
</head>
<body class="dashboard">
    <nav class="navbar">
        <ul>
            <li><a href="dashboard.php">Inicio</a></li>
            <li><a href="mis_tickets.php">Mis Tickets</a></li>
            <li><a href="cambios.php">Cambios</a></li>
            <li><a href="cambio_form.php" class="active">Crear Cambio</a></li>
            <li><a href="logout.php">Cerrar Sesión</a></li>
        </ul>
    </nav>
    <main class="main-content">
        <h1>Crear Cambio</h1>
        <form id="cambio-form">
            <label>Título: <input type="text" name="titulo_cambio" required></label><br>
            <label>Descripción: <textarea name="desc_cambio" required></textarea></label><br>
            <label>Servicio:
                <select name="id_servicio" id="id_servicio" required>
                    <option value="">Cargando servicios...</option>
                </select>
            </label><br>
            <label>Tipo:
                <select name="tipo_cambio" required>
                    <option value="normal">Normal</option>
                    <option value="urgente">Urgente</option>
                    <option value="emergencia">Emergencia</option>
                    <option value="estandar">Estándar</option>
                </select>
            </label><br>
            <label>Fecha: <input type="date" name="fecha_cambio" required></label><br>
            <label>Riesgo:
                <select name="riesgo_cambio" required>
                    <option value="bajo">Bajo</option>
                    <option value="medio">Medio</option>
                    <option value="alto">Alto</option>
                </select>
            </label><br>
            <label>Estado:
                <select name="estado_cambio" required>
                    <option value="borrador">Borrador</option>
                    <option value="pendiente">Pendiente Aprobación</option>
                    <option value="aprobado">Aprobado</option>
                    <option value="en_progreso">En Progreso</option>
                    <option value="completado">Completado</option>
                    <option value="rechazado">Rechazado</option>
                </select>
            </label><br>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
        <div id="msg"></div>
    </main>
    <script>
    // Cargar servicios en el select
    fetch('http://localhost:3000/api/services')
        .then(res => res.json())
        .then(servicios => {
            const select = document.getElementById('id_servicio');
            select.innerHTML = '<option value="">Seleccione un servicio</option>';
            servicios.forEach(s => {
                select.innerHTML += `<option value="${s.id_servicio}">${s.nom_servicio}</option>`;
            });
        });

    document.getElementById('cambio-form').onsubmit = function(e) {
        e.preventDefault();
        const data = Object.fromEntries(new FormData(this));
        fetch('http://localhost:3000/api/cambios', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(data)
        }).then(res => res.json())
        .then(resp => {
            document.getElementById('msg').innerHTML = "Cambio guardado correctamente";
            this.reset();
        }).catch(() => {
            document.getElementById('msg').innerHTML = "Error al guardar el cambio";
        });
    }
    </script>
</body>
</html>