<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(CategoryTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(CreateAdminUserSeeder::class);

        $this->call(CreateDescuentoSeeder::class);
        $this->call(CreateFoodSeeder::class);
        $this->call(CreateObjPerdidoSeeder::class);
        $this->call(CreatePartidaSeeder::class);
        $this->call(CreatePedidoSeeder::class);
        $this->call(CreatePlayerSeeder::class);

        // $this->call(RoleSeeder::class);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
