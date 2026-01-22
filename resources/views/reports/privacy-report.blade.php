<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        * { font-family: Arial Unicode MS; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        th, td { padding: 8px; border: 1px solid #ddd; }
        th { background: #f8f9fa; }
        .header { text-align: center; margin-bottom: 30px; }
        .stats { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .stat-box { text-align: center; padding: 10px; border: 1px solid #ddd; width: 23%; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Reporte de Autorizaciones</h2>
        <p>{{ $fecha }}</p>
    </div>

    <div class="stats">
        <div class="stat-box">
            <h3>{{ $stats['total'] }}</h3>
            <p>Total</p>
        </div>
        <div class="stat-box">
            <h3>{{ $stats['autorizados'] }}</h3>
            <p>Autorizados</p>
        </div>
        <div class="stat-box">
            <h3>{{ $stats['aceptados'] }}</h3>
            <p>Aceptados</p>
        </div>
        <div class="stat-box">
            <h3>{{ $stats['completos'] }}</h3>
            <p>Completos</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Datos</th>
                <th>Aviso</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($candidates as $c)
            <tr>
                <td>{{ $c['id'] }}</td>
                <td>{{ $c['nombre_completo'] }}</td>
                <td>{{ $c['email'] }}</td>
                <td>{{ $c['datos'] }}</td>
                <td>{{ $c['aviso'] }}</td>
                <td>{{ $c['estado'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
