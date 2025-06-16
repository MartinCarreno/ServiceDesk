<?php
include 'session_validation.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoriaId = $_POST['categoria'] ?? null;
    $tipoTicket = $_POST['tipo_ticket'] ?? null;
    $servicioId = $_POST['servicio'] ?? null;
    $descripcion = $_POST['descripcion'] ?? null;

    // Validar los datos
    if (empty($categoriaId) || empty($tipoTicket) || empty($servicioId) || empty($descripcion)) {
        $_SESSION['error'] = 'Todos los campos son obligatorios.';
        header('Location: ../templates/create_ticket_form.php');
        exit;
    }

    // Asignar SLA según el tipo de ticket
    $slaId = ($tipoTicket === 'incidente') ? 1 : 2;

    // Preparar los datos para enviar al backend
    $data = [
        'tipo_ticket' => $tipoTicket,
        'categoria_id' => $categoriaId,
        'servicio_id' => $servicioId,
        'descripcion' => $descripcion,
        'sla_id' => $slaId,
        'usuario_id' => $_SESSION['usuario']['id'], // ID del usuario autenticado
    ];

    // Enviar datos al backend
    $url = 'http://localhost:3000/api/tickets/create';
    $options = [
        'http' => [
            'header'  => "Content-Type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode($data),
        ],
    ];

    $context  = stream_context_create($options);
    $result = @file_get_contents($url, false, $context);
    $response = $result ? json_decode($result, true) : null;

    // Manejar la respuesta del backend
    if ($response && isset($response['success']) && $response['success']) {
        // Redirigir según el tipo de usuario
        if ($_SESSION['usuario']['tipo'] === 'agente') {
            header('Location: ../templates/agent/dashboard.php');
        } else {
            header('Location: ../templates/user/user_dashboard.php');
        }
        exit;
    } else {
        // Manejar errores del backend
        $errorMsg = $response['msg'] ?? 'Error desconocido al crear el ticket.';
        $_SESSION['error'] = $errorMsg;
        header('Location: ../templates/create_ticket_form.php');
        exit;
    }
}
?>