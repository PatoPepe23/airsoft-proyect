<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'id' => 1,
            'fullname' => 'dunkerque',
            'password' => bcrypt('12345678'),
            'DNI' => '12345678A',
            'phonenumber' => '622421325',

            'email' => 'dunkerque.airsoft.camp@gmail.com',
        ]);

        $user2 = User::create([
            'id' => 2,
            'fullname' => 'dunkerque2',
            'password' => bcrypt('12345678'),
            'DNI' => '1111111A',
            'phonenumber' => '632421325',
            'email' => 'dunkerque.airsoft2.camp@gmail.com',
        ]);
        $user3 = User::create([
            'id' => 3,
            'fullname' => 'dunkerque3',
            'password' => bcrypt('12345678'),
            'DNI' => '1111111B',
            'phonenumber' => '632421326',
            'email' => 'dunkerque.airsoft3.camp@gmail.com',
        ]);

        $role = Role::create(['name' => 'admin']);
        $role2 = Role::create(['name' => 'moderator']);
        $role3 = Role::create(['name' => 'user']);
        $permissions = [
            'role-list',
            'permission-list',
            'permission-edit',
            'user-list',
            'user-edit',
            'post-list',
            'post-edit',
            'post-all',
        ];
        $role2->syncPermissions($permissions);

        $permissions = [
            'post-list',
            'post-create',
            'post-edit',
            'post-delete',
            'post-list'
        ];
        $role3->syncPermissions($permissions);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
        $user2->assignRole([$role2->id]);
        $user3->assignRole([$role3->id]);


    }
}
