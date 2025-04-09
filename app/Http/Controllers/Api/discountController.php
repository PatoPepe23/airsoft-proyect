<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\pedido;
use App\Models\descuento;

class discountController extends Controller
{
    public function store(Request $request)
    {
        $descuento = null;

        if ($request->discountinput) {
            // Buscar el código en la tabla de descuentos
            $descuento = descuento::where('codigo', $request->discountinput)->first();


        }

        // Retornar una respuesta JSON
        return response()->json(['porcentaje' => $descuento->porcentaje], 201);
    }
}
