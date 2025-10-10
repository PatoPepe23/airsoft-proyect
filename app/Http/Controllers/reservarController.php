<?php

namespace App\Http\Controllers;

use App\Mail\BookingCanceled;
use App\Models\pedido;
use App\Models\Player;
use Illuminate\Http\Request;
use App\Models\partida;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class reservarController extends Controller
{
    public function store(Request $request)
    {
        // Validación según skip
        if ($request->skip) {
            $validated = $request->validate([
                'DNI' => 'required|string|max:20',
                'nombrecompleto' => 'required|string|max:100',
                'alquiler' => 'required|boolean',
                'dentro' => 'required|boolean',
            ]);
        } else {
            $validated = $request->validate([
                'DNI' => 'required|string|max:20',
                'nombrecompleto' => 'required|string|max:100',
                'telefono' => 'nullable|numeric',
                'email' => 'required|email',
                'team' => 'nullable|string',
                'alquiler' => 'required|boolean',
                'dentro' => 'required|boolean',
            ]);
        }

        // Buscar jugador existente o crearlo
        $player = Player::where($validated)->first();
        if (!$player) {
            $player = Player::create($validated);
        }

        // Crear pedido
        $pedido = Pedido::create([
            'cost' => $request->precio
        ]);

        if ($request->food && $request->food_id) {
            $pedido->food_id = $request->food_id;
            $pedido->save();
        }

        // Obtener partida
        try {
            $partidafecha = Carbon::createFromFormat('d-m-Y', $request->partida_id)->format('Y-m-d');
        } catch (\Throwable $th) {
            $partidafecha = $request->partida_id;
        }

        $partida = Partida::where('fecha', $partidafecha)
            ->where('shift', $request->shift)
            ->first();

        if (!$partida) {
            return response()->json(['error' => 'Partida no encontrada'], 404);
        }

        // Validar reserva existente
        $existingReservation = $partida->players()->where('DNI', $request->DNI)->exists();
        if ($existingReservation) {
            return response()->json(['error' => 'Este jugador ya tiene una reserva para esta partida.'], 409);
        }

        // Reducir plazas


        $plazasPartida = $partida->plazas > 0;

        $plazasAlquiler = $partida->alquiler > 0;

        if ($plazasPartida) {
            if ($request->alquiler) {
                if ($plazasAlquiler) {
                    $partida->alquiler -=1;
                    $partida->plazas -= 1;
                    $partida->save();
                } else {
                    return response()->json(['error' => 'Límite de alquileres alcanzado'], 409);
                }
            } else {
                $partida->plazas -= 1;
                $partida->save();
            }
        } else {
            return response()->json(['error' => 'No quedan plazas disponibles'], 409);
        }

        // Adjuntar jugador a la partida
        $pivotData = ['pedido_id' => $pedido->id];
        if ($request->skip) {
            $pivotData['entrada'] = true;
        }
        $player->partidas()->attach($partida->id, $pivotData);

        return response()->json($player, 201);
    }


    public function cancel($sendmail, $dni, $partida, $email)
    {

        $partidaFecha = Carbon::parse(trim($partida))->format('Y-m-d');


        $player = Player::where('DNI', $dni)->first();

        if (!$player) {
            return response('Jugador no encontrado', 404);
        }

        $partida = partida::where('fecha', $partidaFecha)
            ->where('shift', 0)
            ->first();

        if (!$partida) {
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

        $data = [
            'dni' => $dni,
            'partida_id' => $partidaFecha,
        ];

        if ($sendmail) {
            Mail::to($email)->send(new BookingCanceled($data));
        }

        return response('Reserva cancelada correctamente, se le ha enviado un correo conforme se ha cancelado, ya puede cerrar esta pestaña', 200);


    }

    public function misReservas($dni)
    {
        // Buscar el jugador por el DNI pasado como parámetro
        $player = Player::where('DNI', $dni)->first();

        // Si no existe, devolvemos un array vacío
        if (!$player) {
            return response()->json('no se encuentra al player');
        }



        // Sacamos las reservas del jugador
        $reservas = $player->partidas()->withPivot('pedido_id')->get()->map(function($partida) use ($player) {
            $fecha = $partida->fecha ? Carbon::parse($partida->fecha)->format('d-m-Y') : null;

            return [
                'DNI' => $player->DNI,
                'nombrecompleto' => $player->nombrecompleto,
                'fecha' => $fecha,
                'hora' => '8:00',
                'pedido_id' => $partida->pivot->pedido_id
            ];
        });

        return response()->json($reservas);
    }


}
