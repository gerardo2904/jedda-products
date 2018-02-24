<?php

use Illuminate\Database\Seeder;
use App\Permiso;

class PermisosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {	
    	// 0->admin 1->compras/ventas/produccion 2->produccion 3->rep
        Permiso::create([
           'id'     => 0, 
           'name'   => 'Administrador', 
        ]);

        Permiso::insert([
           'id'     => 1, 
           'name'   => 'Compras/Ventas', 
        ]);

        Permiso::insert([
           'id'     => 2, 
           'name'   => 'Producción', 
        ]);

        Permiso::insert([
           'id'     => 3, 
           'name'   => 'Reportes', 
        ]);

    }
}
