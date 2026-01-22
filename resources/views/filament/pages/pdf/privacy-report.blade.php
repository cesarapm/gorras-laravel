<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Helvetica, Arial, sans-serif; font-size: 12px; }
        h1 { text-align: center; margin-bottom: 20px; }
        .stats { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .stat-box { width: 23%; text-align: center; border: 1px solid #ccc; padding: 10px; border-radius: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 5px; text-align: left; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h1>Reporte de Autorizaciones</h1>
    <p>Fecha: {{ $fecha }}</p>

    <div class="stats">
        <div class="stat-box">Total: {{ $stats['total'] }}</div>
        <div class="stat-box">Autorizados: {{ $stats['autorizados'] }}</div>
        <div class="stat-box">Aceptados: {{ $stats['aceptados'] }}</div>
        <div class="stat-box">Completos: {{ $stats['completos'] }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Datos Compartidos</th>
                <th>Aviso Privacidad</th>
                <th>Estado General</th>
                <th>Fecha Registro</th>
            </tr>
        </thead>
        <tbody>
            @foreach($candidates as $c)
            <tr>
                <td>{{ $c->id }}</td>
                <td>{{ $c->nombre }} {{ $c->apellido }}</td>
                <td>{{ $c->email }}</td>
                <td>{{ $c->autorizacion_datos_compartidos ? 'SI' : 'NO' }}</td>
                <td>{{ $c->aviso_privacidad2_aceptado ? 'SI' : 'NO' }}</td>
                <td>{{ ($c->autorizacion_datos_compartidos && $c->aviso_privacidad2_aceptado) ? 'COMPLETO' : 'INCOMPLETO' }}</td>
                <td>{{ $c->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
