<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class sandwichesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $price = 6.00;
        DB::table('sandwiches')->insert([
            ['type' => '01.- Lomo queso pan con tomate', 'price' => $price],
            ['type' => '02.- Bacon queso pan con tomate', 'price' => $price],
            ['type' => '03.- Tortilla francesa queso pan con tomate', 'price' => $price],
            ['type' => '04.- salchichas queso pan con tomate', 'price' => $price],
            ['type' => '07.- Fuet pan con tomate', 'price' => $price],
            ['type' => '08.- Jamon serrano pan con tomate', 'price' => $price],
            ['type' => '17.- Jamon serrano pan sin tomate', 'price' => $price],
        ]);
    }
}
