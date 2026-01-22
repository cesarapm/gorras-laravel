<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background-color: #ffffff;
            padding: 30px;
            border: 1px solid #dee2e6;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-radius: 0 0 10px 10px;
            font-size: 14px;
            color: #6c757d;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .token-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #007bff;
        }
        .warning {
            background-color: #fff3cd;
            color: #856404;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #ffc107;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🔐 Restablecer Contraseña</h1>
        <h2>Factor Uno - Portal de Candidatos</h2>
    </div>

    <div class="content">
        <p>Hola <strong>{{ $candidate->nombre }}</strong>,</p>

        <p>Recibimos una solicitud para restablecer la contraseña de tu cuenta en Factor Uno.</p>

        <div class="token-info">
            <h3>📧 Información para restablecer:</h3>
            <p><strong>Email:</strong> {{ $email }}</p>
            <p><strong>Token:</strong> {{ $token }}</p>
        </div>

        <p>Para restablecer tu contraseña, utiliza los siguientes datos en tu aplicación:</p>

        <ul>
            <li>Copia el token mostrado arriba</li>
            <li>Pégalo en el formulario de restablecimiento</li>
            <li>Ingresa tu nueva contraseña</li>
        </ul>

        <div class="warning">
            <strong>⚠️ Importante:</strong>
            <ul>
                <li>Este token expira en 24 horas</li>
                <li>Solo puede ser usado una vez</li>
                <li>Si no solicitaste este cambio, ignora este email</li>
            </ul>
        </div>

        <p>Si tienes algún problema, contacta a nuestro equipo de soporte.</p>

        <p>Saludos,<br>
        <strong>Equipo Factor Uno</strong></p>
    </div>

    <div class="footer">
        <p>© {{ date('Y') }} Factor Uno. Todos los derechos reservados.</p>
        <p>Este es un email automático, por favor no respondas a este mensaje.</p>
    </div>
</body>
</html>
