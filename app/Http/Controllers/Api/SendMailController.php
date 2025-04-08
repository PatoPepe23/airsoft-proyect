<?php
namespace App\Http\Controllers\Api;
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmation;


class SendMailController extends Controller
{
    public function send(Request $request)
    {
        $data = $request->all();

        //$qrCodeBase64 = base64_encode(QrCode::format('png')->size(200)->generate($data['DNI']));

        Mail::to($data['email'])->send(new BookingConfirmation($data));

        return response()->json(['message' => 'Correo enviado']);
    }
}
