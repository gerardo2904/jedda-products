<?php

use Illuminate\Database\Seeder;
use App\Unit;

class UnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1->Piezas 2->Etiquetas 3->Metros 4->Pulgadas 5->Pies 6->Cms, 7->Rollos
        Unit::create([
           'id'     => 1, 
           'name'   => 'Piezas', 
        ]);

        Unit::insert([
           'id'     => 2, 
           'name'   => 'Etiquetas', 
        ]);

        Unit::insert([
           'id'     => 3, 
           'name'   => 'Metros', 
        ]);

        Unit::insert([
           'id'     => 4, 
           'name'   => 'Pulgadas', 
        ]);

        Unit::insert([
           'id'     => 5, 
           'name'   => 'Pies', 
        ]);

        Unit::insert([
           'id'     => 6, 
           'name'   => 'Cms', 
        ]);

        Unit::insert([
           'id'     => 7, 
           'name'   => 'Rollos', 
        ]);    }
}
