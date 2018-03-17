<?php

use Illuminate\Database\Seeder;
use App\RollProduct;

class RollProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1->General 2->Materia prima 3->Core 4->Leader 5->Sticker
        RollProduct::create([
           'id'     => 1, 
           'name'   => 'General', 
        ]);

        RollProduct::insert([
           'id'     => 2, 
           'name'   => 'Materia Prima', 
        ]);

        RollProduct::insert([
           'id'     => 3, 
           'name'   => 'Core', 
        ]);

        RollProduct::insert([
           'id'     => 4, 
           'name'   => 'Leader', 
        ]);

        RollProduct::insert([
           'id'     => 5, 
           'name'   => 'Sticker', 
        ]);

        RollProduct::insert([
           'id'     => 6, 
           'name'   => 'Producto Terminado', 
        ]);
    }

}
