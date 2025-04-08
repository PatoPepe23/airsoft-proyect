<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Confirmación de reserva</title>
</head>
<body>
<h1>Hola {{ $data['nombrecompleto'] }}!</h1>
<p>Gracias por reservar en Dunkerque Airsoft Camp.</p>

<ul>
    <li><strong>DNI:</strong> {{ $data['DNI'] }}</li>
    <li><strong>Email:</strong> {{ $data['email'] }}</li>
    <li><strong>Teléfono:</strong> {{ $data['telefono'] }}</li>
    <li><strong>Alquiler:</strong> {{ $data['alquiler'] ? 'Sí' : 'No' }}</li>
    <li><strong>Comida:</strong> {{ $data['food'] ? 'Sí' : 'No' }}</li>
    <li><strong>Hora:</strong> {{ $data['shift'] ? '16:00' : '8:00'}}</li>
</ul>
<p><img src="data:image/png;base64,{{ $qrCodeBase64 }}" alt="QR Code"></p>

<p>¡Nos vemos en el campo!</p>
</body>
</html>
