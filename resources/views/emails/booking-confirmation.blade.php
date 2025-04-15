<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Confirmación de reserva</title>
</head>
<body>
<h2>Gracias {{ $data['nombrecompleto'] }} por reservar en Dunkerque Airsoft Camp!</h2>
<h2>Hora y Dia de reserva: {{ $data['shift'] ? '16:00' : '8:00'}} {{$data['partida_id']}}</h2>
<h3><u>Datos de reserva</u></h3>
<ul>
    <li><strong>DNI:</strong> {{ $data['DNI'] }}</li>
    <li><strong>Email:</strong> {{ $data['email'] }}</li>
    <li><strong>Teléfono:</strong> {{ $data['telefono'] }}</li>
    <li><strong>Alquiler:</strong> {{ $data['alquiler'] ? 'Sí' : 'No' }}</li>
    <li><strong>Comida:</strong> {{ $data['food'] ? 'Sí' : 'No' }}</li>
</ul>
<h3>- Precio a pagar: {{$data['precio']}} €</h3>
<img src="cid:qr_cid" width="200"/>

<p><strong>Tienes Adjuntado el QR con el que tendras que pasar el dia de la reserva.</strong></p>
<p>¡Nos vemos en el campo!</p>
</body>
</html>
