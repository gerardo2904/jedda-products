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
           'id'           => 1,
           'name'         => 'Jedda TTR', 
           'rfc'          => '', 
    		   'address'      => 'Gustavo Diaz Ordaz No 1111-10', 
    		   'city'         => 'Tijuana, B.C.', 
    		   'cp'           => '22117', 
    		   'tel'          => '6643845074', 
           'email'        => 'facturacion@jeddattr.com',
           'es_proveedor' => false,
           'activo'       => true,

        ]);

        $file  = 'user-default.png';
        $path = public_path() . '/images/clients';
        $fileName = uniqid() . $file;
        $moved = \File::copy($path.'/'.$file, $path.'/'.$fileName);
        
        if ($moved){
          ClientImage::create([
            'image' => $fileName,
            'client_id' => 1,
            'featured'   => 1
        ]);    
        }

        


        Client::insert([
           'id'           => 2,
           'name'         => 'Dynic USA', 
           'rfc'          => '', 
           'address'      => '4750 N.E. Dawson Creek Drive', 
           'city'         => 'Hillsboro, Oregon', 
           'cp'           => '97124', 
           'tel'          => '5036931070', 
           'email'        => 'enrique@dynic.com',
           'es_proveedor' => false,
           'activo'       => true,

        ]);

        $file  = 'user-default.png';
        $path = public_path() . '/images/clients';
        $fileName = uniqid() . $file;
        $moved = \File::copy($path.'/'.$file, $path.'/'.$fileName);
        
        if ($moved){
         ClientImage::create([
            'image' => $fileName,
            'client_id' => 2,
            'featured'   => 1
        ]);
        }
    }
}


