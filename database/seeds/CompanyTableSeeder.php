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

        CompanyImage::create([
            'image' => 'company-default.png',
            'company_id' => 1,
        ]);

        Company::insert([
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

        CompanyImage::insert([
            'image' => 'company-default.png',
            'company_id' => 1,
        ]);

    }
}
