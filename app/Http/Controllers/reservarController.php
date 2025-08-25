<?php

namespace App\Http\Controllers;

use App\Models\pedido;
use App\Models\Player;
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

//        $playervalidation = player::where($validated)->first();
//
//
//        if (!$playervalidation) {
//            $player = player::create($validated);
//        }

        $player = player::create($validated);

        $pedido = Pedido::create([
            'cost' => $request->precio
        ]);
        if ($request->food && $request->food_id) {
            // Aquí actualizas la relación, no es necesario usar `attach`, solo asignas el `food_id`
            $pedido->food_id = $request->food_id;
            $pedido->save();  // Guarda los cambios en el pedido
        }

        $partidafecha = null;
        try {
            $partidafecha = Carbon::createFromFormat('d-m-Y', $request->partida_id)->format('Y-m-d');
        } catch (\Throwable $th) {
            $partidafecha = $request->partida_id;
        }


        $partida = partida::where('fecha', $partidafecha)->where('shift', $request->shift)->first();

        $partida->plazas -= 1;
        $partida->save();

        $player->partidas()->attach($partida->id, ['pedido_id' => $pedido->id]);

        // Retornar una respuesta JSON
        return response()->json($player, 201);
    }

    public function cancel($dni, $partida)
    {
        $partidaFecha = Carbon::createFromFormat('d-m-Y', $partida)->format('Y-m-d');




        $player = Player::where('DNI', $dni)->first();

        if (! $player) {
            return response('Jugador no encontrado', 404);
        }

        $partida = Partida::where('fecha', $partidaFecha)
            ->where('shift', 0)
            ->first();

        if (! $partida) {
            return response('Partida no encontrada', 404);
        }

        $pivotData = $player->partidas()
            ->where('partida_id', $partida->id)
            ->first()
            ->pivot;

        if (!$pivotData) {
            return response()->json(['message' => 'No se encontró la reserva.'], 404);
        }

        $player->partidas()->detach($partida->id);


        pedido::destroy($pivotData->pedido_id);


        $partida->plazas += 1;
        $partida->save();

        // 7. (Opcional) eliminar al player si no tiene más partidas
        if ($player->partidas()->count() === 0) {
            $player->delete();
        }

        return redirect('/')->with('success', 'Reserva cancelada correctamente.');


    }
}
