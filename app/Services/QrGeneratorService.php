<?php
namespace App\Services;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Str;

class QrGeneratorService
{
    public function generate(string $text): array
    {
        // Crear QR
        $qrCode = new QrCode($text);
        $writer = new PngWriter();
        $result = $writer->write($qrCode);


        $filename = 'qr_' . Str::random(10) . '.png';
        $tempPath = public_path("images/QR/$filename");
        $result->saveToFile($tempPath);

        return [
            'filename' => $filename,
            'path' => $tempPath,
        ];
    }
}
