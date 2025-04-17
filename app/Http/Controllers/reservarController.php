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
        $validated = $request->validate([
            'DNI' => 'required|string|max:20',
            'nombrecompleto' => 'required|string|max:100',
            'telefono' => 'nullable|numeric',
            'email' => 'required|email',
            'team' => 'nullable|string',
            'alquiler' => 'required|boolean',
            'dentro' => 'required|boolean',
            'shift' => 'required|boolean'
        ]);

        $player = player::create($validated);

        $pedido = Pedido::create([
            'cost' => $request->precio
        ]);
        if ($request->food && $request->food_id) {
            // Aquí actualizas la relación, no es necesario usar `attach`, solo asignas el `food_id`
            $pedido->food_id = $request->food_id;
            $pedido->save();  // Guarda los cambios en el pedido
        }

        $partidafecha = Carbon::createFromFormat('d-m-Y', $request->partida_id)->format('Y-m-d');

        $partida = partida::where('fecha', $partidafecha)->where('shift', $request->shift)->first();

        $partida->plazas -= 1;
        $partida->save();

        $player->partidas()->attach($partida->id, ['pedido_id' => $pedido->id]);

        // Retornar una respuesta JSON
        return response()->json($player, 201);
    }
}
