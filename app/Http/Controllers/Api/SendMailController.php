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

        $reservadoDni = $request->DNI;

        // Si la reserva es para el mismo usuario autenticado
        if (auth()->check() && auth()->user()->DNI === $reservadoDni) {
            // Usamos su QR ya almacenado
            $qr = public_path("images/QR/" . auth()->user()->qrimg);
        } else {
            // Generamos un nuevo QR para la persona de esta reserva
            $qrPath = $this->qrService->generate($reservadoDni);
            $qr = $qrPath['path'];
        }

        // Enviamos el correo de confirmación con los datos correctos
        Mail::to($data['email'])->send(new BookingConfirmation($data, $qr));

        // Si el QR fue generado temporalmente, lo borramos
        if (! (auth()->check() && auth()->user()->DNI === $reservadoDni)) {
            if (file_exists($qr)) {
                unlink($qr);
            }
        }

        // Enviar email con el QR


        return response()->json(['message' => 'Correo enviado']);
    }

}
