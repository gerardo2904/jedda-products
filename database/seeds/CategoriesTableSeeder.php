<?php

use Illuminate\Database\Seeder;
use App\Category;
use App\CategoryImage;


class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         
        $category =  Category::create([
           'name'    => 'General',
           'description' => 'Categoria general'
        ]);

        CategoryImage::create([
            'image' => 'default.png',
            'category_id' => 1,
        ]);

/*        $imagescat = factory(CategoryImage::class)->make([
            'image' => '/images/products/default.png',
            'category_id' => 1,
        ]);  */

    }
}
