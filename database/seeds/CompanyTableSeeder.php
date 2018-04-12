<?php

use Illuminate\Database\Seeder;

use App\Company;
use App\CompanyImage;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Company::create([
          'id'      => 1,
           'name'     => 'Jedda TTR', 
           'rfc'      => 'JTT110309VD8', 
		   'address'  => 'Blvd Diaz Ordaz No. 1111, int 101', 
		   'city'     => 'Tijuana, B.C.', 
		   'cp'       => '22117', 
		   'tel'      => '6643825074', 
           'email'    => 'luis.ramirez@jedda.com',
           'contact'  => 'Jose Ramirez',
           'activo'   => true,
        ]);

        $file  = 'jedda-logo.jpg';
        $path = public_path() . '/images/companies';
        $fileName = uniqid() . $file;
        $moved = \File::copy($path.'/'.$file, $path.'/'.$fileName);
        
        if ($moved){
         CompanyImage::create([
            'image' => $fileName,
            'company_id' => 1,
            'featured'   => 1
        ]);
        }

        Company::insert([
           'id'      => 2,
           'name'     => 'Bajasys LLC', 
           'rfc'      => '', 
       'address'  => '9923 Via de la Amistad, Suite  105', 
       'city'     => 'San Diego, CA.', 
       'cp'       => '92154', 
       'tel'      => '16196610748', 
           'email'    => 'jose@bajasys.net',
           'contact'  => 'Jose Ramirez',
           'activo'   => true,
        ]);

        $file  = 'bajasys_logo.jpg';
        $path = public_path() . '/images/companies';
        $fileName = uniqid() . $file;
        $moved = \File::copy($path.'/'.$file, $path.'/'.$fileName);
        
        if ($moved){
         CompanyImage::insert([
            'image' => $fileName,
            'company_id' => 2,
            'featured'   => 1
        ]);
        }

    }
}
