<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class usersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sandwiches')->insert([
            ['fullname' => 'testing', 'mail' => 'testing@gmail.com', 'phone' => 111111111, 'DNI' => '12345678A', 'password'],
        ]);
    }
}
