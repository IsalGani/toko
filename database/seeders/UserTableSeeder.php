<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = array(
            [
                'name' => 'Administrator',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('123'),
                'foto' => '/img/user.jpg',
                'level' => 1
            ],
            [
                'name' => 'Kasir',
                'email' => 'kasir@gmail.com',
                'password' => bcrypt('123'),
                'foto' => '/img/user.jpg',
                'level' => 2
            ],
            [
                'name' => 'Pelanggan',
                'email' => 'user@gmail.com',
                'password' => bcrypt('123'),
                'foto' => '/img/user.jpg',
                'level' => 0
            ]
        );

        array_map(function (array $user) {
            User::query()->updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }, $users);


        // Admin
        User::create([
            'name' => 'Admin 1',
            'email' => 'admin1@mail.com',
            'password' => Hash::make('password'),
            'level' => 1,
        ]);
        User::create([
            'name' => 'Admin 2',
            'email' => 'admin2@mail.com',
            'password' => Hash::make('password'),
            'level' => 1,
        ]);

        // Kasir
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => "Kasir $i",
                'email' => "kasir$i@mail.com",
                'password' => Hash::make('password'),
                'level' => 2,
            ]);
        }

        // Pelanggan
        for ($i = 1; $i <= 50; $i++) {
            User::create([
                'name' => "Pelanggan $i",
                'email' => "pelanggan$i@mail.com",
                'password' => Hash::make('password'),
                'level' => 0,
            ]);
        }
    }
}
