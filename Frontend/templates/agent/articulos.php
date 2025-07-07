<?php
include '../../includes/session_validation.php';

// Obtener categorías principales
$catApiUrl = 'http://localhost:3000/api/categorias';
$artApiUrl = 'http://localhost:3000/api/articulos';

$categorias = [];
$articulos = [];
$error = null;

// Obtener categorías principales
try {
    $catResponse = @file_get_contents($catApiUrl);
    if ($catResponse !== FALSE) {
        $categorias = json_decode($catResponse, true);
    }
} catch (Exception $e) {
    $error = "Error al obtener las categorías: " . $e->getMessage();
}

// Obtener artículos
try {
    $artResponse = @file_get_contents($artApiUrl);
    if ($artResponse !== FALSE) {
        $data = json_decode($artResponse, true);
        $articulos = isset($data['articulos']) ? $data['articulos'] : $data;
    }
} catch (Exception $e) {
    $error = "Error al obtener los artículos: " . $e->getMessage();
}

// Agrupar artículos por categoría
$articulosPorCategoria = [];
foreach ($articulos as $articulo) {
    $cat = $articulo['cate_articulo'] ?? 'Sin Categoría';
    $articulosPorCategoria[$cat][] = $articulo;
}

if (empty($categorias)) {
    $categorias = [];
    foreach (array_keys($articulosPorCategoria) as $cat) {
        $categorias[] = ['nom_categoria' => $cat];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Base de Conocimiento</title>
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
                <li><a href="../agent/articulos.php">Articulos</a></li>
                <li><a href="../create_ticket_form.php">Crear Ticket</a></li>
                <li><a href="../agent/crear_activo.php">Agregar Activo</a></li>
                <li><a href="../logout.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </nav>
    <main class="main-content">
        <h1>Base de Conocimiento</h1>
        <?php if ($error): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php elseif (empty($categorias)): ?>
            <div class="empty-state">
                <div class="empty-state-icon">📋</div>
                <h3>No hay categorías disponibles</h3>
            </div>
        <?php else: ?>
            <div class="accordion-container">
                <?php foreach ($categorias as $i => $categoria): ?>
                    <div class="accordion-item">
                        <button class="accordion-header" type="button" aria-expanded="false" aria-controls="cat<?= $i ?>">
                            <?= htmlspecialchars($categoria['nom_categoria'] ?? $categoria['cate_articulo'] ?? 'Sin Categoría') ?>
                            <span class="accordion-icon">▼</span>
                        </button>
                        <div class="accordion-body" id="cat<?= $i ?>">
                            <?php
                            $catName = $categoria['nom_categoria'] ?? $categoria['cate_articulo'] ?? '';
                            $articulosCat = $articulosPorCategoria[$catName] ?? [];
                            if (empty($articulosCat)): ?>
                                <p style="margin:1rem 0;">No hay artículos en esta categoría.</p>
                            <?php else: ?>
                                <div class="accordion-container">
                                <?php foreach ($articulosCat as $j => $articulo): ?>
                                    <div class="accordion-item">
                                        <button class="accordion-header" type="button" aria-expanded="false" aria-controls="articulo<?= $i ?>_<?= $j ?>">
                                            <?= htmlspecialchars($articulo['titulo_articulo'] ?? $articulo['titulo'] ?? '') ?>
                                            <span class="accordion-icon">▼</span>
                                        </button>
                                        <div class="accordion-body" id="articulo<?= $i ?>_<?= $j ?>">
                                            <p><strong>Subcategoría:</strong> <?= htmlspecialchars($articulo['subcate_articulo'] ?? $articulo['subcategoria'] ?? '') ?></p>
                                            <p><strong>Fecha:</strong> <?= htmlspecialchars($articulo['fecha_articulo'] ?? $articulo['fecha'] ?? '') ?></p>
                                            <p><strong>Visibilidad:</strong> <?= htmlspecialchars($articulo['visibilidad'] ?? '') ?></p>
                                            <p><strong>Contenido:</strong><br><?= nl2br(htmlspecialchars($articulo['conten_articulo'] ?? $articulo['contenido'] ?? '')) ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
    <script>
        // Accordion principal y secundario
        document.querySelectorAll('.accordion-header').forEach(btn => {
            btn.addEventListener('click', function() {
        const expanded = this.getAttribute('aria-expanded') === 'true';
        // Cierra todos los hermanos
        const parent = this.parentElement.parentElement;
        parent.querySelectorAll('.accordion-header').forEach(b => {
            if (b !== this) {
                b.setAttribute('aria-expanded', 'false');
            }
        });
        // Toggle actual
        this.setAttribute('aria-expanded', expanded ? 'false' : 'true');
    });
        });
        // Inicializa todos cerrados
        document.querySelectorAll('.accordion-body').forEach(body => body.style.maxHeight = null);
    </script>
</body>
</html>