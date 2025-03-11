<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\food;

class CreateFoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $food = Food::create([
            'id' => 1,
            'nombre' => 'Lomo queso pan con tomate'
        ]);
        $food = Food::create([
            'id' => 2,
            'nombre' => 'Bacon queso pan con tomate'
        ]);
        $food = Food::create([
            'id' => 3,
            'nombre' => 'Tortilla francesa queso pan con tomate'
        ]);
        $food = Food::create([
            'id' => 4,
            'nombre' => 'Salchichas queso pan con tomate'
        ]);
        $food = Food::create([
            'id' => 7,
            'nombre' => 'Fuet pan con tomate'
        ]);
        $food = Food::create([
            'id' => 8,
            'nombre' => 'Jamon serrano pan con tomate'
        ]);
        $food = Food::create([
            'id' => 17,
            'nombre' => 'Jamon serrano pan sin tomate'
        ]);
    }
}
