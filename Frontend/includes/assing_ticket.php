<?php
include 'session_validation.php';

if (isset($_GET['ticket_id'])) {
    $ticket_id = $_GET['ticket_id'];

    $url = "http://localhost:3000/api/tickets/assign/$ticket_id";
    $data = [
        'agente_id' => $_SESSION['usuario']['id'], // ID del agente
    ];
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

    if ($result['success']) {
        header('Location: ../templates/agent/dashboard.php');
    } else {
        echo 'Error: ' . $result['msg'];
    }
}
?>