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
        //Admins

        $user = User::create([
            'id' => 1,
            'fullname' => 'dunkerque',
            'password' => bcrypt('Dunkerque@12345678'),
            'DNI' => '11111111A',
            'phonenumber' => '123456789',
            'email' => 'dunkerque.airsoft.camp@gmail.com',
            'qrimg' => 'test1.png'
        ]);

        $user2 = User::create([
            'id' => 2,
            'fullname' => 'Robert',
            'password' => bcrypt('Dunkerque@1234'),
            'DNI' => '11111111B',
            'phonenumber' => '123456789',
            'email' => 'robert@gmail.com',
            'qrimg' => 'test2.png'
        ]);
        $user3 = User::create([
            'id' => 3,
            'fullname' => 'Germán',
            'password' => bcrypt('Dunkerque@1234'),
            'DNI' => '11111111C',
            'phonenumber' => '123456789',
            'email' => 'german@gmail.com',
            'qrimg' => 'test3.png'
        ]);
        $user4 = User::create([
            'id' => 4,
            'fullname' => 'Jose',
            'password' => bcrypt('Dunkerque@1234'),
            'DNI' => '11111111D',
            'phonenumber' => '123456789',
            'email' => 'jose@gmail.com',
            'qrimg' => 'test4.png'
        ]);
        $user5 = User::create([
            'id' => 5,
            'fullname' => 'Marcos',
            'password' => bcrypt('Dunkerque@1234'),
            'DNI' => '11111111E',
            'phonenumber' => '123456789',
            'email' => 'marcos@gmail.com',
            'qrimg' => 'test5.png'
        ]);
        $user6 = User::create([
            'id' => 6,
            'fullname' => 'Raul',
            'password' => bcrypt('Dunkerque@1234'),
            'DNI' => '11111111F',
            'phonenumber' => '123456789',
            'email' => 'raulpuchol@gmail.com',
            'qrimg' => 'test6.png'
        ]);

        //Arbitros

        $user7 = User::create([
            'id' => 7,
            'fullname' => 'Albert',
            'password' => bcrypt('Dunkerque_1234'),
            'DNI' => '11111111G',
            'phonenumber' => '123456789',
            'email' => 'albert@gmail.com',
            'qrimg' => 'test7.png'
        ]);
        $user8 = User::create([
            'id' => 8,
            'fullname' => 'Alberto',
            'password' => bcrypt('Dunkerque_1234'),
            'DNI' => '11111111H',
            'phonenumber' => '123456789',
            'email' => 'alberto@gmail.com',
            'qrimg' => 'test8.png'
        ]);
        $user9 = User::create([
            'id' => 9,
            'fullname' => 'Cristina',
            'password' => bcrypt('Dunkerque_1234'),
            'DNI' => '11111111I',
            'phonenumber' => '123456789',
            'email' => 'cristina@gmail.com',
            'qrimg' => 'test9.png'
        ]);
        $user10 = User::create([
            'id' => 10,
            'fullname' => 'Aaron',
            'password' => bcrypt('Dunkerque_1234'),
            'DNI' => '11111111J',
            'phonenumber' => '123456789',
            'email' => 'aaron@gmail.com',
            'qrimg' => 'test10.png'
        ]);

        $user11 = User::create([
            'id' => 11,
            'fullname' => 'Alex',
            'password' => bcrypt('Dunkerque_1234'),
            'DNI' => '11111111K',
            'phonenumber' => '123456789',
            'email' => 'alex@gmail.com',
            'qrimg' => 'test11.png'
        ]);

        $user12 = User::create([
            'id' => 12,
            'fullname' => 'David',
            'password' => bcrypt('Dunkerque_1234'),
            'DNI' => '11111111L',
            'phonenumber' => '123456789',
            'email' => 'david@gmail.com',
            'qrimg' => 'test12.png'
        ]);

        $user13 = User::create([
            'id' => 13,
            'fullname' => 'Fina',
            'password' => bcrypt('Dunkerque_1234'),
            'DNI' => '11111111M',
            'phonenumber' => '123456789',
            'email' => 'fina@gmail.com',
            'qrimg' => 'test13.png'
        ]);

        $user14 = User::create([
            'id' => 14,
            'fullname' => 'Ignasi',
            'password' => bcrypt('Dunkerque_1234'),
            'DNI' => '11111111N',
            'phonenumber' => '123456789',
            'email' => 'ignasi@gmail.com',
            'qrimg' => 'test14.png'
        ]);

        $user15 = User::create([
            'id' => 15,
            'fullname' => 'Iván',
            'password' => bcrypt('Dunkerque_1234'),
            'DNI' => '11111111O',
            'phonenumber' => '123456789',
            'email' => 'ivan@gmail.com',
            'qrimg' => 'test15.png'
        ]);

        $user16 = User::create([
            'id' => 16,
            'fullname' => 'Izan',
            'password' => bcrypt('Dunkerque_1234'),
            'DNI' => '11111111P',
            'phonenumber' => '123456789',
            'email' => 'izan@gmail.com',
            'qrimg' => 'test16.png'
        ]);

        $user17 = User::create([
            'id' => 17,
            'fullname' => 'Jaume',
            'password' => bcrypt('Dunkerque_1234'),
            'DNI' => '11111111Q',
            'phonenumber' => '123456789',
            'email' => 'jaume@gmail.com',
            'qrimg' => 'test17.png'
        ]);

        $user18 = User::create([
            'id' => 18,
            'fullname' => 'Pau',
            'password' => bcrypt('Dunkerque_1234'),
            'DNI' => '11111111R',
            'phonenumber' => '123456789',
            'email' => 'pau@gmail.com',
            'qrimg' => 'test18.png'
        ]);

        $user19 = User::create([
            'id' => 19,
            'fullname' => 'Pino',
            'password' => bcrypt('Dunkerque_1234'),
            'DNI' => '11111111S',
            'phonenumber' => '123456789',
            'email' => 'pino@gmail.com',
            'qrimg' => 'test19.png'
        ]);

        $user20 = User::create([
            'id' => 20,
            'fullname' => 'Pol',
            'password' => bcrypt('Dunkerque_1234'),
            'DNI' => '11111111T',
            'phonenumber' => '123456789',
            'email' => 'pol@gmail.com',
            'qrimg' => 'test20.png'
        ]);

        $user21 = User::create([
            'id' => 21,
            'fullname' => 'Rafa',
            'password' => bcrypt('Dunkerque_1234'),
            'DNI' => '11111111U',
            'phonenumber' => '123456789',
            'email' => 'rafa@gmail.com',
            'qrimg' => 'test21.png'
        ]);

        $user22 = User::create([
            'id' => 22,
            'fullname' => 'Raúl',
            'password' => bcrypt('Dunkerque_1234'),
            'DNI' => '11111111V',
            'phonenumber' => '123456789',
            'email' => 'raul@gmail.com',
            'qrimg' => 'test22.png'
        ]);

        $user23 = User::create([
            'id' => 23,
            'fullname' => 'Selma',
            'password' => bcrypt('Dunkerque_1234'),
            'DNI' => '11111111W',
            'phonenumber' => '123456789',
            'email' => 'selma@gmail.com',
            'qrimg' => 'test23.png'
        ]);

        $user24 = User::create([
            'id' => 24,
            'fullname' => 'Xavi',
            'password' => bcrypt('Dunkerque_1234'),
            'DNI' => '11111111X',
            'phonenumber' => '123456789',
            'email' => 'xavi@gmail.com',
            'qrimg' => 'test24.png'
        ]);




        $role = Role::create(['name' => 'admin']);
        $role2 = Role::create(['name' => 'arbitro']);
        $role3 = Role::create(['name' => 'user']);
        $permissions = [
            'user-list',
            'user-edit',
            'post-list',
            'post-edit',
            'post-all',
        ];
        $role2->syncPermissions($permissions);

        $permissions = [
            'post-list',
        ];
        $role3->syncPermissions($permissions);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        //Admins
        $user->assignRole([$role->id]);
        $user2->assignRole([$role->id]);
        $user3->assignRole([$role->id]);
        $user4->assignRole([$role->id]);
        $user5->assignRole([$role->id]);
        $user6->assignRole([$role->id]);

        //Arbis
        $user7->assignRole([$role2->id]);
        $user8->assignRole([$role2->id]);
        $user9->assignRole([$role2->id]);
        $user10->assignRole([$role2->id]);
        $user11->assignRole([$role2->id]);
        $user12->assignRole([$role2->id]);
        $user13->assignRole([$role2->id]);
        $user14->assignRole([$role2->id]);
        $user15->assignRole([$role2->id]);
        $user16->assignRole([$role2->id]);
        $user17->assignRole([$role2->id]);
        $user18->assignRole([$role2->id]);
        $user19->assignRole([$role2->id]);
        $user20->assignRole([$role2->id]);
        $user21->assignRole([$role2->id]);
        $user22->assignRole([$role2->id]);
        $user23->assignRole([$role2->id]);
        $user24->assignRole([$role2->id]);
    }
}
