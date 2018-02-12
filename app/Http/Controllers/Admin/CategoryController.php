<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use APP\Product;

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

        $category->save(); //insert en tabla categories
            
        return redirect('/admin/categories');
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
        $category->save(); //update en tabla categories
            
        return redirect('/admin/categories');
    }
    
    
    public function destroy($id)
    {
        //$product = Product::find($id)->count();

        // registrar nuevo producto en la bd
        //dd($request->all());   //imprime lo solicitado y termina ejecucion.
        $category = Category::find($id);
        $category->delete(); //delete en tabla productos
            
        return back();
    }
}
