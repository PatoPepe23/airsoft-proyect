<?php
namespace App\Http\Controllers\Api;
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmation;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;



class SendMailController extends Controller
{
    public function send(Request $request)
    {
        $data = $request->all();


        $qrCode = new QrCode($data['DNI']);

        // Usar el escritor PNG, que usará la librería GD por defecto
        $writer = new PngWriter();

        // Generar el código QR como imagen PNG
        $result = $writer->write($qrCode);

        $qrCodeBase64 = base64_encode($result->getString());

        Mail::to($data['email'])->send(new BookingConfirmation($data, $qrCodeBase64));

        return response()->json(['message' => 'Correo enviado']);
    }
}
