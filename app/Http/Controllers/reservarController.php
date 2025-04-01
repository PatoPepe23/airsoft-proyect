<?php

namespace App\Http\Controllers;

use App\Models\pedido;
use App\Models\player;
use Illuminate\Http\Request;
use App\Models\pedidocomida;
use App\Models\partidaplayerpedido;

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
        ]);

        $player = player::create($validated);

        $pedido = Pedido::create([
            'cost' => $preciobase,
        ]);
        $pedido->comidas->sync([2,4,6]);
        if ($request->food) {
            $foodpedido = pedidocomida::create([
                'pedido_id' => $pedido->id,
                'food_id' => $request->food_id
            ]);

            $pedido->food_id = $foodpedido->id;
            $pedido->save();
        }

        partidaplayerpedido::create([
            'player_id' => $player->id,
            'partida_id' => $request->partida_id,
            'pedido_id' => $pedido->id
        ]);

        // Retornar una respuesta JSON
        return response()->json($player, 201);
    }
}
