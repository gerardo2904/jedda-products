<?php

use Illuminate\Database\Seeder;



class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UsersTableSeeder::class);
         $this->call(ClientsTableSeeder::class);
         $this->call(CategoriesTableSeeder::class);
         $this->call(ProductsTableSeeder::class);
         $this->call(CompanyTableSeeder::class);
         $this->call(PermisosTableSeeder::class);
         $this->call(UnitsTableSeeder::class);
    }
}
