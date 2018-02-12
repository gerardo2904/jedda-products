<?php

use Illuminate\Database\Seeder;
use App\User;

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
           'name'     => 'garreola', 
           'email'    => 'geranegocios29@gmail.com',
           'password' => bcrypt('123456'),
            'permisos'   => 0,
            'empresa_id'  => 0,
        ]);
    }
}
