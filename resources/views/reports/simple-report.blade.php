<html>
<head>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 5px; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h1>{{ $titulo }}</h1>
    <p>Fecha: {{ $fecha }}</p>

    <table>
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Estado</th>
        </tr>
        @foreach($registros as $r)
        <tr>
            <td>{{ $r['id'] }}</td>
            <td>{{ $r['email'] }}</td>
            <td>{{ $r['estado'] }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>
