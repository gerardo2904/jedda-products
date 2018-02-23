<?php

use Illuminate\Database\Seeder;
use App\Client;
use App\ClientImage;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Client::create([
           'name'     => 'Cliente de prueba', 
           'rfc'      => 'PRBA110309SDF', 
		   'address'  => 'Blvd Insurgentes 1099', 
		   'city'     => 'Tijuana, B.C.', 
		   'cp'       => '22334', 
		   'tel'      => '6647908917', 
           'email'    => 'prueba@gmail.com',
           'activo'   => true,

        ]);

        ClientImage::create([
            'image' => 'user-default.png',
            'client_id' => 1,
        ]);
    }
}


