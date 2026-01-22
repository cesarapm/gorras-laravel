<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación Exitosa</title>
    <meta http-equiv="refresh" content="5;url={{ $redirectUrl }}">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }
        .container {
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-top: 50px;
        }
        .success-icon {
            color: #28a745;
            font-size: 48px;
            margin-bottom: 20px;
        }
        .btn {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
        }
        .redirect-message {
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }
        h1 {
            color: #28a745;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-icon">✓</div>
        <h1>¡Verificación Exitosa!</h1>
        <p>Hola {{ $candidateName ?? 'Usuario' }},</p>
        <p>{{ $message }}</p>
        <p>Tu cuenta ha sido activada correctamente y ahora puedes acceder a todos los servicios de nuestra plataforma.</p>
        <a href="{{ $redirectUrl }}" class="btn">Ir al sitio web</a>
        <p class="redirect-message">Serás redirigido automáticamente en 5 segundos...</p>
    </div>
</body>
</html>
