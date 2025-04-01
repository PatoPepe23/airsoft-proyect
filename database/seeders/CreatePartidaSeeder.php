<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\partida;


class CreatePartidaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
        public function run(): void
    {
        $fechaInicio = Carbon::now()->next(Carbon::SATURDAY); // Próximo sábado
        $fechaFin = $fechaInicio->copy()->addYears(10); // Hasta dentro de 10

        while ($fechaInicio <= $fechaFin) {
            // Sábado
            Partida::create([
                'fecha' => $fechaInicio,
                'plazas' => 220,
                'tipo' => "dominguera",
                'cancelled' => false,
                'shift' => 0
            ]);

            Partida::create([
                'fecha' => $fechaInicio,
                'plazas' => 220,
                'tipo' => "dominguera",
                'cancelled' => false,
                'shift' => 1
            ]);

            // Domingo
            $fechaInicio->addDay();
            Partida::create([
                'fecha' => $fechaInicio,
                'plazas' => 220,
                'tipo' => "dominguera",
                'cancelled' => false,
                'shift' => 0
            ]);

            // Avanza al siguiente sábado
            $fechaInicio->next(Carbon::SATURDAY);
        }
    }
}
