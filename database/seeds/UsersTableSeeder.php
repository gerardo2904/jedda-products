<?php

use Illuminate\Database\Seeder;
use App\User;
use App\UserImage;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
           'name'     => 'Gerardo Arreola', 
           'email'    => 'geranegocios29@gmail.com',
           'password' => bcrypt('123456'),
            'permisos'   => 0,
            'empresa_id'  => 1,
        ]);

        UserImage::create([
            'image' => 'user-default.png',
            'user_id' => 1,
        ]);

        User::insert([
           'name'     => 'Jose Ramirez', 
           'email'    => 'jose@bajasys.net',
           'password' => bcrypt('123456'),
            'permisos'   => 0,
            'empresa_id'  => 2,
        ]);

        UserImage::insert([
            'image' => 'user-default.png',
            'user_id' => 2,
        ]);

    }
}
