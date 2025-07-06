<?php
include 'session_validation.php';

if (isset($_GET['ticket_id'])) {
    $ticket_id = $_GET['ticket_id'];
    $input = json_decode(file_get_contents('php://input'), true);
    $mensaje = $input['mensaje_finalizacion'] ?? '';

    $url = "http://localhost:3000/api/tickets/finalize/$ticket_id";
    $data = ['mensaje_finalizacion' => $mensaje];
    $options = [
        'http' => [
            'header'  => "Content-Type: application/json\r\nAuthorization: Bearer {$_SESSION['token']}\r\n",
            'method'  => 'POST',
            'content' => json_encode($data),
        ],
    ];

    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);
    $result = json_decode($response, true);

    echo json_encode($result);
} else {
    echo json_encode(['success' => false, 'msg' => 'No se proporcionó un ID de ticket.']);
}
?>