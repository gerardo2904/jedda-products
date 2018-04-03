<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\CategoryImage;
use App\Product;
use File;

Use Session;
Use Redirect;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(10);
        return view('admin.categories.index')->with(compact('categories'));   // listado  
    }
    
    public function create()
    {
        return view('admin.categories.create');   // formulario
    }
    
    public function store(Request $request)
    {
        // registrar nuevo producto en la bd
        //dd($request->all());   //imprime lo solicitado y termina ejecucion.
        
        //validaciones 
        
        $messages = [
            'name.required' => 'Es necesario ingresar el nombre de categoría',
            'name.min' => 'El nombre categoría debe tener al menos 3 caracteres',
            'description.required' => 'La descripción es un campo obligatorio',
            'description.max' => 'La descripción solo admite hasta 200 caracteres',
            
        ];
        
        $rules = [
            'name' => 'required|min:3',
            'description' => 'required|max:200'
        ];
        
        $this->validate($request,$rules,$messages);  
        
        $category = new Category();
        $category->name              = $request->input('name');
        $category->description       = $request->input('description');

        if ($request->input('es_subcategoria') == 1)
            $category->es_subcategoria    = $request->input('es_subcategoria');
        else
            $category->es_subcategoria = 0;


        $category->save(); //insert en tabla categories

        $cat = Category::where('name',$category->name)->first();
        $idc=$cat->id;

        // Imagen por default....

        $file  = 'default.png';
        $path = public_path() . '/images/categories';
        //$path = public_path();
        $fileName = uniqid() . $file;
        //$moved = $file->copy($path.'/'.$file, $path.'/'.$fileName);
        $moved = \File::copy($path.'/'.$file, $path.'/'.$fileName);
        
        // crear 1 registro en la tabla category_images
        if ($moved){
            $categoryImage = new CategoryImage();
            $categoryImage->image = $fileName;
            // $productImage->featured = false;   // Ya esta en la definicion de la tabla esta condicion, por eso se comenta.
            $categoryImage->category_id = $idc;
            $categoryImage->featured = 1;
            $categoryImage->save();  //INSERT
        }


        ////////////////

        Session::flash('message','La categoria '.$category->name.' se ha agregado con exito.');
            
        //return redirect('/admin/categories');
        return redirect('/admin/categories')->with('status', 'exito');
    }
    
    public function edit($id)
    {
        
        $category = Category::find($id);
        return view('admin.categories.edit')->with(compact('category'));   // formulario
    }
    
    public function update(Request $request, $id)
    {
        // Editar producto en la bd
        //dd($request->all());   //imprime lo solicitado y termina ejecucion.
        
        //validaciones 
        
        $messages = [
            'name.required' => 'Es necesario ingresar el nombre de categoría',
            'name.min' => 'El nombre de categoría debe tener al menos 3 caracteres',
            'description.required' => 'La descripción es un campo obligatorio',
            'description.max' => 'La descripción solo admite hasta 200 caracteres'            
        ];
        
        $rules = [
            'name' => 'required|min:3',
            'description' => 'required|max:200'
        ];
        
        $this->validate($request,$rules,$messages);  
        
        $category = Category::find($id);
        $category->name              = $request->input('name');
        $category->description       = $request->input('description');

        $category->es_subcategoria  = $request->input('es_subcategoria');

        if ($category->es_subcategoria <> 1)
            $category->es_subcategoria = 0;
        else            
            $category->es_subcategoria = 1;

        $category->save(); //update en tabla categories

        Session::flash('message','La categoria '.$category->name.' se ha modificado con exito.');
            
        //return redirect('/admin/categories');
        return redirect('/admin/categories')->with('status', 'exito');
    }
    
    
    public function destroy($id)
    {
        // registrar nuevo producto en la bd
        //dd($request->all());   //imprime lo solicitado y termina ejecucion.
        $category = Category::find($id);
        $nomcat = $category->name;
        $images = CategoryImage::where('category_id',$id);
        $imagenes = CategoryImage::where('category_id',$id)->count();

        $prod = Product::where('category_id',$id)->count();

        

        if($prod == 0){
            if($imagenes > 0){

                $images->each(function ($images){
                if (substr($images->image,0,4)==="http")  // Si empieza con http o sea que es link
                {
                    $deleted = true;
                 }else {
                    if ($images->image ==="default.png"){
                         $deleted = true;
                    }else{
                            $fullPath = public_path() . '/images/categories/' . $images->image;
                         $deleted = File::delete($fullPath);
                    }
                }

                });

                $images->where('category_id',$id)->delete();

            }


            $category->delete(); //delete en tabla productos
            Session::flash('message','Se ha borrado exitosamente la categoria '.$nomcat.'.');
            return redirect('/admin/categories')->with('status', 'exito');
        }
        else {
            Session::flash('message','La categoria '.$nomcat.' no se puede borrar porque tiene productos asignados.');
            return redirect('/admin/categories')->with('status', 'noexito');
        }

        
        
    }
}
