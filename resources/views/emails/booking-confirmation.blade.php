<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Confirmación de reserva</title>
</head>
<body>
<h2>Gracias {{ $data['nombrecompleto'] }} por reservar en Dunkerque Airsoft Camp!</h2>
<h2>Hora: {{ $data['shift'] ? '16:00' : '8:00'}}</h2>
<h2>Día: {{$data['partida_id']}}</h2>
<h3><u>Datos de la reserva</u></h3>
<ul>
    <li><strong>DNI:</strong> {{ $data['DNI'] }}</li>
    <li><strong>Email:</strong> {{ $data['email'] }}</li>
    <li><strong>Teléfono:</strong> {{ $data['telefono'] }}</li>
    <li><strong>Alquiler:</strong> {{ $data['alquiler'] ? 'Sí' : 'No' }}</li>
    <!--<li><strong>Comida:</strong> {{ $data['food'] ? 'Sí' : 'No' }}</li>-->
</ul>
<h3>- Precio a pagar: {{$data['precio']}} €</h3>
<h2>Todos los pagos se realizaran en efectivo, una vez en el campo.</h2>
<img src="cid:qr_cid" width="200"/>

<p><strong>Tienes adjuntado el QR con el que tendras que pasar el día de la reserva.</strong></p>
<p><strong>Si deseas un bocadillo, nada mas entrar en la nave a mano izquierda tendras la recepción.</strong></p>
<p>¡Nos vemos en el campo!</p>

<p><strong>Si deseas cancelar la partida presione el link para cancelar reserva.</strong></p>
<a href="{{ url('/cancelar-reserva/'. true .'/' . $data['DNI'] . '/' . $data['partida_id'] . '/' . $data['email']) }}">
    Cancelar mi reserva
</a>
</body>
</html>
