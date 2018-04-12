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
            'id'                => 1,
            'name'              => 'Ribbons',
            'description'       => 'Ribbons',
            'es_subcategoria'   => 0
        ]);

        $file  = 'default.png';
        $path = public_path() . '/images/categories';
        $fileName = uniqid() . $file;
        $moved = \File::copy($path.'/'.$file, $path.'/'.$fileName);
        
        if ($moved){
          CategoryImage::create([
            'image' => $fileName,
            'category_id' => 1,
            'featured'   => 1
        ]);
        }

        $category =  Category::insert([
            'id'                => 2,
            'name'              => 'Resin Ribbons',
            'description'       => 'Resin Ribbons',
            'es_subcategoria'   => 1
        ]);

        $file  = 'default.png';
        $path = public_path() . '/images/categories';
        $fileName = uniqid() . $file;
        $moved = \File::copy($path.'/'.$file, $path.'/'.$fileName);
        
        if ($moved){
          CategoryImage::insert([
            'image' => $fileName,
            'category_id' => 2,
            'featured'   => 1
        ]);
        }
        
        $category =  Category::insert([
            'id'                => 3,
            'name'              => 'Core',
            'description'       => 'Core',
            'es_subcategoria'   => 0
        ]);

        $file  = 'default.png';
        $path = public_path() . '/images/categories';
        $fileName = uniqid() . $file;
        $moved = \File::copy($path.'/'.$file, $path.'/'.$fileName);
        
        if ($moved){
          CategoryImage::insert([
            'image' => $fileName,
            'category_id' => 3,
            'featured'   => 1
        ]);
        }

        $category =  Category::insert([
            'id'                => 4,
            'name'              => 'Core 1"',
            'description'       => 'Core 1"',
            'es_subcategoria'   => 1
        ]);

        $file  = 'default.png';
        $path = public_path() . '/images/categories';
        $fileName = uniqid() . $file;
        $moved = \File::copy($path.'/'.$file, $path.'/'.$fileName);
        
        if ($moved){
          CategoryImage::insert([
            'image' => $fileName,
            'category_id' => 4,
            'featured'   => 1
        ]);
        }

        $category =  Category::insert([
            'id'                => 5,
            'name'              => 'Leader',
            'description'       => 'Leader',
            'es_subcategoria'   => 0
        ]);

        $file  = 'default.png';
        $path = public_path() . '/images/categories';
        $fileName = uniqid() . $file;
        $moved = \File::copy($path.'/'.$file, $path.'/'.$fileName);
        
        if ($moved){
          CategoryImage::insert([
            'image' => $fileName,
            'category_id' => 5,
            'featured'   => 1
        ]);
        }

        $category =  Category::insert([
            'id'                => 6,
            'name'              => 'Silver Leader',
            'description'       => 'Silver Leader',
            'es_subcategoria'   => 1
        ]);

        $file  = 'default.png';
        $path = public_path() . '/images/categories';
        $fileName = uniqid() . $file;
        $moved = \File::copy($path.'/'.$file, $path.'/'.$fileName);
        
        if ($moved){
          CategoryImage::insert([
            'image' => $fileName,
            'category_id' => 6,
            'featured'   => 1
        ]);
        }

        $category =  Category::insert([
            'id'                => 7,
            'name'              => 'Blue Leader',
            'description'       => 'Blue Leader',
            'es_subcategoria'   => 1
        ]);

        $file  = 'default.png';
        $path = public_path() . '/images/categories';
        $fileName = uniqid() . $file;
        $moved = \File::copy($path.'/'.$file, $path.'/'.$fileName);
        
        if ($moved){
          CategoryImage::insert([
            'image' => $fileName,
            'category_id' => 7,
            'featured'   => 1
        ]);
        }

        $category =  Category::insert([
            'id'                => 8,
            'name'              => 'Clear Leader',
            'description'       => 'Clear Leader',
            'es_subcategoria'   => 1
        ]);

        $file  = 'default.png';
        $path = public_path() . '/images/categories';
        $fileName = uniqid() . $file;
        $moved = \File::copy($path.'/'.$file, $path.'/'.$fileName);
        
        if ($moved){
          CategoryImage::insert([
            'image' => $fileName,
            'category_id' => 8,
            'featured'   => 1
        ]);
        }

        $category =  Category::insert([
            'id'                => 9,
            'name'              => 'Etiquetas',
            'description'       => 'Etiquetas',
            'es_subcategoria'   => 0
        ]);

        $file  = 'default.png';
        $path = public_path() . '/images/categories';
        $fileName = uniqid() . $file;
        $moved = \File::copy($path.'/'.$file, $path.'/'.$fileName);
        
        if ($moved){
          CategoryImage::insert([
            'image' => $fileName,
            'category_id' => 9,
            'featured'   => 1
        ]);
        }

        $category =  Category::insert([
            'id'                => 10,
            'name'              => 'Wax Ribbons',
            'description'       => 'Wax Ribbons',
            'es_subcategoria'   => 1
        ]);

        $file  = 'default.png';
        $path = public_path() . '/images/categories';
        $fileName = uniqid() . $file;
        $moved = \File::copy($path.'/'.$file, $path.'/'.$fileName);
        
        if ($moved){
          CategoryImage::insert([
            'image' => $fileName,
            'category_id' => 10,
            'featured'   => 1
        ]);
        }

        $category =  Category::insert([
            'id'                => 11,
            'name'              => 'Etiqueta Rectangular',
            'description'       => 'Etiqueta Rectangular',
            'es_subcategoria'   => 1
        ]);

        $file  = 'default.png';
        $path = public_path() . '/images/categories';
        $fileName = uniqid() . $file;
        $moved = \File::copy($path.'/'.$file, $path.'/'.$fileName);
        
        if ($moved){
          CategoryImage::insert([
            'image' => $fileName,
            'category_id' => 11,
            'featured'   => 1
        ]);
        }

        $category =  Category::insert([
            'id'                => 12,
            'name'              => 'Jumbo Wax',
            'description'       => 'Jumbo Wax',
            'es_subcategoria'   => 1
        ]);

        $file  = 'default.png';
        $path = public_path() . '/images/categories';
        $fileName = uniqid() . $file;
        $moved = \File::copy($path.'/'.$file, $path.'/'.$fileName);
        
        if ($moved){
          CategoryImage::insert([
            'image' => $fileName,
            'category_id' => 12,
            'featured'   => 1
        ]);
        }

    }
}
