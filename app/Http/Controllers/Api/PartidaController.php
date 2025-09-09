<?php

namespace App\Http\Controllers\Api;
use Carbon\Carbon;
use App\Jobs\DeletePartida;
use App\Http\Controllers\Controller;
use http\Params;
use Illuminate\Http\Request;
use App\Models\partida;
use App\Models\RegistroPartida;

class PartidaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $data)
    {
        $year = $data->input('year');
        $month = $data->input('month');
        $limitMonth = $data->input('limitMonth');

        $date = Carbon::create($year, $month, 1)->format('Y-m-d');
        $limitDate = Carbon::create($year, $limitMonth, 1)->format('Y-m-d');

        $games = Partida::whereBetween('fecha', [$date, $limitDate])->get();

        return Response()->json($games, 200);

    }

//    public function index(Request $data)
//    {
//        $year = $data->input('year');
//        $month = $data->input('month');
//        $limitMonth = $data->input('limitMonth');
//
//        return gettype($year);
//
//        // Validación básica de los datos de entrada
//        if (!is_numeric($year) || !is_numeric($month) || !is_numeric($limitMonth)) {
//            return Response()->json(['error' => 'Invalid input parameters'], 400);
//        }
//
//        $date = Carbon::create($year, $month, 1);
//        $limitDate = Carbon::create($year, $limitMonth, 1);
//
//        // Manejo de rangos de fechas que abarcan dos años
//        if ($limitDate->lt($date)) {
//            $limitDate->addYear(); // Si limitMonth es anterior a month, incrementa el año en limitDate
//        }
//
//        $games = Partida::whereBetween('fecha', [$date->format('Y-m-d'), $limitDate->format('Y-m-d')])->get();
//
//        return Response()->json($games, 200);
//    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
