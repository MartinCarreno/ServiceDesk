<?php
include 'session_validation.php';

if (isset($_GET['ticket_id'])) {
    $ticket_id = $_GET['ticket_id'];

    $url = "http://localhost:3000/api/tickets/finalize/$ticket_id";
    $options = [
        'http' => [
            'header'  => "Content-Type: application/json\r\nAuthorization: Bearer {$_SESSION['token']}\r\n",
            'method'  => 'POST',
        ],
    ];

    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);
    $result = json_decode($response, true);

    if ($result['success']) {
        echo json_encode(['success' => true, 'msg' => 'Ticket finalizado correctamente.']);
        header('Location: ../templates/agent/dashboard.php');
    } else {
        echo 'Error: ' . ($result['msg'] ?? 'No se pudo finalizar el ticket.');
    }
} else {
    echo 'Error: No se proporcionó un ID de ticket.';
}
?>