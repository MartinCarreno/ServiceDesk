<?php
include '../../includes/session_validation.php';

$error = null;
$success = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'serial_activo' => $_POST['serial_activo'],
        'marca_activo' => $_POST['marca_activo'],
        'modelo_activo' => $_POST['modelo_activo'],
        'cate_activo' => $_POST['cate_activo'],
        'subcate_activo' => $_POST['subcate_activo'],
        'fec_compra' => $_POST['fec_compra'],
        'estado_activo' => $_POST['estado_activo'],
        'ubica_activo' => $_POST['ubica_activo'],
        'id_usuario_resp' => $_POST['id_usuario_resp'],
    ];

    $opts = [
        'http' => [
            'method' => 'POST',
            'header' => "Content-Type: application/json\r\n",
            'content' => json_encode($data)
        ]
    ];
    $context = stream_context_create($opts);
    $result = @file_get_contents('http://localhost:3000/api/activos', false, $context);

    if ($result === FALSE) {
        $error = "Error al crear el activo.";
    } else {
        $success = "Activo creado correctamente.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Activo</title>
    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body class="dashboard">
    <nav class="navbar">
        <nav>
            <ul>
                <li><a href="../agent/dashboard.php">Inicio</a></li>
                <li><a href="../agent/mis_tickets.php">Mis Ticket</a></li>
                <li><a href="../agent/tickets_pendientes.php">Tickets Pendientes</a></li>
                <li><a href="../agent/mis_tickets_asignados.php">Tickets Asignados</a></li>
                <li><a href="../agent/tickets_finalizados.php">Tickets finalizados</a></li>
                <li><a href="../agent/articulos.php">Artículos</a></li>
                <li><a href="../agent/activos.php">Activos</a></li>
                <li><a href="../agent/crear_activo.php">Agregar Activo</a></li>
                <li><a href="../create_ticket_form.php">Crear Ticket</a></li>
                <li><a href="../logout.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </nav>
    <main class="main-content">
        <h1>Agregar Activo de TI</h1>
        <?php if ($error): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php elseif ($success): ?>
            <div class="success-message"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        <form method="post" class="form-activo">
            <label>Serial: <input type="text" name="serial_activo" required></label>
            <label>Marca: <input type="text" name="marca_activo" required></label>
            <label>Modelo: <input type="text" name="modelo_activo" required></label>
            <label>Categoría:
                <select name="cate_activo" required>
                    <option value="Hardware">Hardware</option>
                </select>
            </label>
            <label>Subcategoría:
                <select name="subcate_activo" required>
                    <option value="PC">PC</option>
                    <option value="Notebook">Notebook</option>
                    <option value="Impresoras">Impresoras</option>
                    <option value="Tablet">Tablet</option>
                    <option value="Switches">Switches</option>
                    <option value="Router">Router</option>
                    <option value="Access Point">Access Point</option>
                    <option value="Firewall">Firewall</option>
                    <option value="Servidores">Servidores</option>
                </select>
            </label>
            <label>Fecha de adquisición: <input type="date" name="fec_compra" required></label>
            <label>Estado:
                <select name="estado_activo" required>
                    <option value="operativo">Operativo</option>
                    <option value="obsoleto">Obsoleto</option>
                </select>
            </label>
            <label>Ubicación: <input type="text" name="ubica_activo" required></label>
            <label>ID Usuario Responsable: <input type="number" name="id_usuario_resp" required></label>
            <button type="submit">Agregar Activo</button>
        </form>
    </main>
</body>
</html>