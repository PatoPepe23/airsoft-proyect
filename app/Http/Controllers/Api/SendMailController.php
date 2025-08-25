<?php
namespace App\Http\Controllers\Api;
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\BookingCanceled;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmation;
use App\Models\partida;


use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Str;

use App\Services\QrGeneratorService;




class SendMailController extends Controller
{

    protected $qrService;

    public function __construct(QrGeneratorService $qrService)
    {
        $this->qrService = $qrService;
    }

    public function send(Request $request)
    {
        $data = $request->all();

        // Si el usuario está autenticado, usamos su QR almacenado
        if (auth()->check() && auth()->user()->qrimg) {
            // Ruta al QR ya existente
            $qr = storage_path("app/public/" . auth()->user()->qrimg);
            Mail::to($data['email'])->send(new BookingConfirmation($data, $qr));
        } else {
            // Si no está autenticado o no tiene QR, generamos uno nuevo con su DNI
            $qrPath = $this->qrService->generate($request->DNI);
            $qr = $qrPath['path'];
            Mail::to($data['email'])->send(new BookingConfirmation($data, $qr));
            if (file_exists($qr)) {
                unlink($qr);
            }
        }

        // Enviar email con el QR


        return response()->json(['message' => 'Correo enviado']);
    }

}
