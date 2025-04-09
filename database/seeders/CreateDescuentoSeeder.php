<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\descuento;

class CreateDescuentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $food = descuento::create([
            'id' => 1,
            'codigo' => 'Aquatik',
            'porcentaje' => '15'
        ]);
        $food = descuento::create([
            'id' => 2,
            'codigo' => '123',
            'porcentaje' => '10'
        ]);
    }
}
