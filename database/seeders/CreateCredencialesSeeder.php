<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Credenciales;

class CreateCredencialesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $credenciales = Credenciales::create([
            'id' => 1,
            'password' => bcrypt('12345678'),
            'DNI' => '1111111A',
            'user_id' => 1
        ]);
    }
}
