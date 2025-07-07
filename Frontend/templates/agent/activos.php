<?php
include '../../includes/session_validation.php';

$apiUrl = 'http://localhost:3000/api/activos';
$activos = [];
$error = null;

try {
    $response = @file_get_contents($apiUrl);
    if ($response !== FALSE) {
        $data = json_decode($response, true);
        $activos = isset($data['activos']) ? $data['activos'] : $data;
    }
} catch (Exception $e) {
    $error = "Error al obtener los activos: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Activos de TI</title>
    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body class="dashboard">
    <nav class="navbar">
        <nav>
            <ul>
                <li><a href="dashboard.php">Inicio</a></li>
                <li><a href="mis_tickets.php">Mis Ticket</a></li>
                <li><a href="tickets_pendientes.php">Tickets Pendientes</a></li>
                <li><a href="mis_tickets_asignados.php">Tickets Asignados</a></li>
                <li><a href="tickets_finalizados.php">Tickets finalizados</a></li>
                <li><a href="articulos.php">Artículos</a></li>
                <li><a href="activos.php">Activos</a></li>
                <li><a href="create_ticket_form.php">Crear Ticket</a></li>
                <li><a href="../agent/crear_activo.php">Agregar Activo</a></li>
                <li><a href="logout.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </nav>
    <main class="main-content">
        <h1>Activos de TI</h1>
        <?php if ($error): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php elseif (empty($activos)): ?>
            <div class="empty-state">
                <div class="empty-state-icon">💻</div>
                <h3>No hay activos registrados</h3>
            </div>
        <?php else: ?>
            <table class="table-activos">
                <thead>
                    <tr>
                        <th>Serial</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Tipo</th>
                        <th>Subtipo</th>
                        <th>Fecha Adquisición</th>
                        <th>Estado</th>
                        <th>Ubicación</th>
                        <th>Responsable</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($activos as $activo): ?>
                        <tr>
                            <td><?= htmlspecialchars($activo['serial_activo']) ?></td>
                            <td><?= htmlspecialchars($activo['marca_activo']) ?></td>
                            <td><?= htmlspecialchars($activo['modelo_activo']) ?></td>
                            <td><?= htmlspecialchars($activo['cate_activo']) ?></td>
                            <td><?= htmlspecialchars($activo['subcate_activo']) ?></td>
                            <td><?= htmlspecialchars(substr($activo['fec_compra'], 0, 10)) ?></td>
                            <td><?= htmlspecialchars($activo['estado_activo']) ?></td>
                            <td><?= htmlspecialchars($activo['ubica_activo']) ?></td>
                            <td>
                                <?php
                                if (isset($activo['Usuario'])) {
                                    echo htmlspecialchars($activo['Usuario']['nom_usuario'] . ' ' . $activo['Usuario']['ape_usuario']);
                                } else {
                                    echo 'Sin asignar';
                                }
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </main>
</body>
</html>