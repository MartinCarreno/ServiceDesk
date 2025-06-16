<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email_usuario'];
    $password = $_POST['pass_usuario'];

    $url = 'http://localhost:3000/api/auth/login';
    $data = [
        'email_usuario' => $email,
        'pass_usuario' => $password,
    ];

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

    if (isset($response['token'])) {
        $_SESSION['token'] = $response['token'];
        $_SESSION['usuario'] = $response['usuario'];

        // Redirigir según el tipo de usuario
        if ($response['usuario']['tipo'] === 'usuario') {
            header('Location: ../templates/user/user_dashboard.php');
        } elseif ($response['usuario']['tipo'] === 'agente') {
            header('Location: ../templates/agent/dashboard.php');
        } else {
            $_SESSION['error'] = 'Error: Tipo de usuario no reconocido.';
            header('Location: ../templates/login.php');
        }
    } else {
        // Manejar el caso de usuario no encontrado o credenciales incorrectas
        if ($response && isset($response['msg'])) {
            $_SESSION['error'] = $response['msg']; // Mensaje del backend
        } else {
            $_SESSION['error'] = 'Usuario no encontrado o credenciales incorrectas.';
        }
        header('Location: ../templates/login.php');
    }
}
?>