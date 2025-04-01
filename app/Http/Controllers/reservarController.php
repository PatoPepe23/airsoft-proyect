<?php

namespace App\Http\Controllers;

use App\Models\pedido;
use App\Models\player;
use Illuminate\Http\Request;
use App\Models\partida;
use Carbon\Carbon;

class reservarController extends Controller
{
    public function store(Request $request)
    {
        $preciobase = 15;

        if($request->alquiler) {
            $preciobase = 40;
        }

        if($request->food) {
            $preciobase += 6;
        }

        $validated = $request->validate([
            'DNI' => 'required|string|max:20',
            'nombrecompleto' => 'required|string|max:100',
            'telefono' => 'required|numeric',
            'email' => 'required|email',
            'team' => 'nullable|string',
            'alquiler' => 'required|boolean',
            'shift' => 'required|boolean'
        ]);

        $player = player::create($validated);

        $pedido = Pedido::create([
            'cost' => $preciobase,
        ]);

        if ($request->food) {
                $pedido->comida()->attach($request->food_id);
        }

        $partidafecha = Carbon::createFromFormat('d-m-Y', $request->partida_id)->format('Y-m-d');

        $partida = partida::where('fecha', $partidafecha)->where('shift', $request->shift)->first();

        $player->partidas()->attach($partida->id, ['pedido_id' => $pedido->id]);

        // Retornar una respuesta JSON
        return response()->json($player, 201);
    }
}
