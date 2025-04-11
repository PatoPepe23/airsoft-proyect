<?php
namespace App\Http\Controllers\Api;
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmation;


use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Str;


class SendMailController extends Controller
{
    public function send(Request $request)
    {
        $data = $request->all();

        // Crear QR
        $qrCode = new QrCode($data['DNI']);
        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        // Guardar imagen temporal
        $filename = 'qr_' . Str::random(10) . '.png';
        $tempPath = storage_path("app/public/$filename");
        $result->saveToFile($tempPath);

        // Enviar email con CID (Content-ID)
        Mail::to($data['email'])->send(new BookingConfirmation($data, $tempPath));

        return response()->json(['message' => 'Correo enviado']);
    }
}
