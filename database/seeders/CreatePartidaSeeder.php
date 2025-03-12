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
            'plazas' => 220,
            'tipo' => "dominguera",
            'cancelled?' => false
        ]);

        $partida = Partida::create([
            'id' => 2,
            'fecha' => '02-03-2025',
            'plazas' => 220,
            'tipo' => "dominguera",
            'cancelled?' => false
        ]);

    }
}
