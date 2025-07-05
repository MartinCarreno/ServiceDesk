<?php
$id = $_GET['id'] ?? 0;
$articles = [
  1 => ['title' => 'Cómo crear un ticket', 'content' => 'Paso 1: Ir a la página de tickets...'],
  2 => ['title' => 'Reestablecer contraseña', 'content' => 'Si olvidaste tu contraseña...']
];
$article = $articles[$id] ?? ['title' => 'No encontrado', 'content' => 'Artículo no disponible.'];
?>
