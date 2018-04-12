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
            'id'      => 1,
           'name'     => 'Gerardo Arreola', 
           'email'    => 'geranegocios29@gmail.com',
           'password' => bcrypt('123456'),
            'permisos'   => 0,
            'empresa_id'  => 1,
        ]);

        $file  = 'user-default.png';
        $path = public_path() . '/images/users';
        $fileName = uniqid() . $file;
        $moved = \File::copy($path.'/'.$file, $path.'/'.$fileName);
        
        if ($moved){
         UserImage::create([
            'image' => $fileName,
            'user_id' => 1,
            'featured'   => 1
        ]);
        }

        

        User::insert([
            'id'      => 2,
           'name'     => 'Jose Ramirez', 
           'email'    => 'jose@bajasys.net',
           'password' => bcrypt('123456'),
            'permisos'   => 0,
            'empresa_id'  => 2,
        ]);

        $file  = 'user-default.png';
        $path = public_path() . '/images/users';
        $fileName = uniqid() . $file;
        $moved = \File::copy($path.'/'.$file, $path.'/'.$fileName);
        
        if ($moved){
         UserImage::insert([
            'image' => $fileName,
            'user_id' => 2,
            'featured'   => 1
        ]);
        }

    }
}
