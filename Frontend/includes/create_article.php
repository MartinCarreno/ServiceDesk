<?php
// Aquí va la lógica real para guardar en base de datos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = $_POST['title'];
  $content = $_POST['content'];

  // Guardar en DB (aquí puedes usar PDO)
  // ...

  header('Location: ../templates/agent/knowledge_base.php');
  exit;
}
?>
