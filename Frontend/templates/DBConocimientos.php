<?php
// Configuración de la base de datos
$host = 'localhost';
$db   = 'servicedesk';
$user = 'tu_usuario';
$pass = 'tu_contraseña';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    $stmt = $pdo->query("SELECT id_articulo, titulo_articulo, conten_articulo, cate_articulo, subcate_articulo, fecha_creacion, visibilidad FROM articulos WHERE estado_publicacion = 1");
    $articulos = $stmt->fetchAll();
} catch (\PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Base de Conocimiento</title>
    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>
    <h1>Base de Conocimiento</h1>
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Título</th>
                <th>Categoría</th>
                <th>Subcategoría</th>
                <th>Fecha</th>
                <th>Visibilidad</th>
                <th>Contenido</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($articulos as $articulo): ?>
                <tr>
                    <td><?= htmlspecialchars($articulo['titulo_articulo']) ?></td>
                    <td><?= htmlspecialchars($articulo['cate_articulo']) ?></td>
                    <td><?= htmlspecialchars($articulo['subcate_articulo']) ?></td>
                    <td><?= htmlspecialchars($articulo['fecha_creacion']) ?></td>
                    <td><?= htmlspecialchars($articulo['visibilidad']) ?></td>
                    <td><?= nl2br(htmlspecialchars($articulo['conten_articulo'])) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>