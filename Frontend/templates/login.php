<?php
session_start();
$error = isset($_SESSION['error']) ? $_SESSION['error'] : null;
unset($_SESSION['error']); // Limpiar el mensaje de error después de mostrarlo
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <title>Login - HelpDesk</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f5f5f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            font-size: 16px;
            line-height: 1.5;
        }

        .contenedor {
            width: 100%;
            max-width: 400px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .caja-login {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: rgba(0, 0, 0, 0.05) 0px 4px 12px;
            width: 100%;
            max-width: 400px;
        }

        h1 {
            color: #333;
            font-size: 32px;
            font-weight: 600;
            text-align: center;
            margin-bottom: 32px;
            letter-spacing: -0.5px;
        }

        label {
            display: block;
            color: #555;
            font-weight: 500;
            margin-bottom: 8px;
            font-size: 14px;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e5e5e5;
            border-radius: 12px;
            font-size: 16px;
            font-family: inherit;
            transition: all 0.2s ease;
            margin-bottom: 20px;
            background: #fafafa;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #4a90e2;
            background: white;
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
        }

        button[type="submit"] {
            width: 100%;
            padding: 14px 24px;
            background: #4a90e2;
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-top: 8px;
            box-shadow: rgba(0, 0, 0, 0.05) 0px 4px 12px;
        }

        button[type="submit"]:hover {
            background: #357abd;
            transform: translateY(-1px);
            box-shadow: rgba(0, 0, 0, 0.1) 0px 6px 16px;
        }

        button[type="submit"]:active {
            transform: translateY(0);
        }

        .error {
            background: #fee;
            color: #c53030;
            padding: 12px 16px;
            border-radius: 12px;
            margin-top: 16px;
            font-size: 14px;
            text-align: center;
            border: 1px solid #fed7d7;
        }

        /* Responsive design */
        @media (max-width: 480px) {
            .contenedor {
                padding: 0 16px;
            }

            .caja-login {
                padding: 32px 24px;
            }

            h1 {
                font-size: 28px;
                margin-bottom: 24px;
            }

            input[type="email"],
            input[type="password"] {
                padding: 14px 16px;
                font-size: 16px; /* Prevent zoom on iOS */
            }

            button[type="submit"] {
                padding: 16px 24px;
            }
        }

        /* Accessibility improvements */
        input[type="email"]:focus-visible,
        input[type="password"]:focus-visible,
        button[type="submit"]:focus-visible {
            outline: 2px solid #4a90e2;
            outline-offset: 2px;
        }

        /* Loading state for button */
        button[type="submit"]:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* Success state styling (for potential future use) */
        .success {
            background: #a8e6cf;
            color: #2d5a3d;
            padding: 12px 16px;
            border-radius: 12px;
            margin-top: 16px;
            font-size: 14px;
            text-align: center;
            border: 1px solid #9dd9c3;
        }
    </style>
</head>

<body class="login">
    <div class="contenedor">
        <form class="caja-login" action="../includes/process_login.php" method="POST">
            <h1>Iniciar Sesión</h1>
            
            <label for="email">Correo Electrónico</label>
            <input type="email" id="email" name="email_usuario" required>
            
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="pass_usuario" required>
            
            <button type="submit">Iniciar Sesión</button>
            
            <?php if ($error): ?>
                <p class="error"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
        </form>
    </div>
</body>

</html>