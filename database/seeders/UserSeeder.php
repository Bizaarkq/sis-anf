<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'admin',
            'email' => 'admin@yopmail.com',
            'password' => bcrypt('12345678'),
        ]);

        User::create([
            'username' => 'analisis',
            'email' => 'analisis@yopmail.com',
            'password' => bcrypt('12345678'),
        ]);

        User::create([
            'username' => 'contador',
            'email' => 'contador@yopmail.com',
            'password' => bcrypt('12345678'),
        ]);

        User::create([
            'username' => 'empresario',
            'email' => 'empresario@yopmail.com',
            'password' => bcrypt('12345678'),
        ]);

        User::create([
            'username' => 'asesor',
            'email' => 'asesor@yopmail.com',
            'password' => bcrypt('12345678'),
        ]);

        User::create([
            'username' => 'analista2',
            'email' => 'analista2@yopmail.com',
            'password' => bcrypt('12345678'),
        ]);

        User::create([
            'username' => 'contador2',
            'email' => 'contador2@yopmail.com',
            'password' => bcrypt('12345678'),
        ]);

        User::create([
            'username' => 'empresario2',
            'email' => 'empresario2@yopmail.com',
            'password' => bcrypt('12345678'),
        ]);

        User::create([
            'username' => 'analista3',
            'email' => 'analista3@yopmail.com',
            'password' => bcrypt('12345678'),
        ]);

        User::create([
            'username' => 'contador3',
            'email' => 'contador3@yopmail.com',
            'password' => bcrypt('12345678'),
        ]);

        User::create([
            'username' => 'empresario3',
            'email' => 'empresario3@yopmail.com',
            'password' => bcrypt('12345678'),
        ]);
    }
}
