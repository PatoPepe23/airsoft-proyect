<?php

namespace Database\Seeders;

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
        $partida = Partida::create([
            'id' => 1,
            'fecha' => '01-03-2025',
            'plazas' => 0,
            'tipo' => "dominguera",
            'cancelled' => false
        ]);

        $partida = Partida::create([
            'id' => 2,
            'fecha' => '02-03-2025',
            'plazas' => 10,
            'tipo' => "dominguera",
            'cancelled' => false
        ]);

        $partida = Partida::create([
            'id' => 3,
            'fecha' => '08-03-2025',
            'plazas' => 45,
            'tipo' => "dominguera",
            'cancelled' => true
        ]);

        $partida = Partida::create([
            'id' => 4,
            'fecha' => '09-03-2025',
            'plazas' => 90,
            'tipo' => "dominguera",
            'cancelled' => false
        ]);

        $partida = Partida::create([
            'id' => 5,
            'fecha' => '15-03-2025',
            'plazas' => 120,
            'tipo' => "dominguera",
            'cancelled' => false
        ]);

        $partida = Partida::create([
            'id' => 6,
            'fecha' => '16-03-2025',
            'plazas' => 150,
            'tipo' => "dominguera",
            'cancelled' => false
        ]);

        $partida = Partida::create([
            'id' => 7,
            'fecha' => '22-03-2025',
            'plazas' => 100,
            'tipo' => "dominguera",
            'cancelled' => false
        ]);

        $partida = Partida::create([
            'id' => 8,
            'fecha' => '23-03-2025',
            'plazas' => 50,
            'tipo' => "dominguera",
            'cancelled' => false
        ]);

        $partida = Partida::create([
            'id' => 9,
            'fecha' => '29-03-2025',
            'plazas' => 180,
            'tipo' => "dominguera",
            'cancelled' => false
        ]);

        $partida = Partida::create([
            'id' => 10,
            'fecha' => '30-03-2025',
            'plazas' => 90,
            'tipo' => "dominguera",
            'cancelled' => false
        ]);

        $partida = Partida::create([
            'id' => 11,
            'fecha' => '05-04-2025',
            'plazas' => 165,
            'tipo' => "dominguera",
            'cancelled' => false
        ]);

        $partida = Partida::create([
            'id' => 12,
            'fecha' => '06-04-2025',
            'plazas' => 25,
            'tipo' => "dominguera",
            'cancelled' => false
        ]);

    }
}
