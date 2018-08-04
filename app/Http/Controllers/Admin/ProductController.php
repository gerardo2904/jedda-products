<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Product;
use App\ProductImage;
use App\almproducts;
use App\Category;
use App\Unit;
use App\RollProduct;
use File;
Use Session;
Use Redirect;
use DB;
Use Barryvdh\DomPDF\Facade as PDF;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        //$products = Product::paginate(10);
        $query    = trim($request->get('searchText'));
        $products = DB::table('products as po')
             ->join('categories as sub','po.subcategory_id','=','sub.id')
             ->join('categories as cat','po.category_id','=','cat.id')
             ->select('po.id','po.name','po.description','cat.name as categoria','sub.name as subcategoria','po.activo')
             ->where('po.name','LIKE','%'.$query.'%')
             ->orderBy('po.name','desc')
             ->paginate(10);


        //return view('admin.products.index')->with(compact('products'));   // listado  
        return view('admin.products.index',["products" => $products, "searchText" => $query]);
    }

    public function pdf()
    {        
        /**
         * toma en cuenta que para ver los mismos 
         * datos debemos hacer la misma consulta
        **/
//        $products = Product::all(); 

        $ps = DB::table('products as po')
             ->join('categories as sub','po.subcategory_id','=','sub.id')
             ->join('categories as cat','po.category_id','=','cat.id')
             ->select('po.id','po.name','po.description','cat.name as categoria','sub.name as subcategoria','po.activo')
             ->orderBy('po.name','desc')
             ->get(); 
            

        $pdf = PDF::loadView('admin.products.pdf.productos', compact('ps'));

        return $pdf->download('listado.pdf');
    }

    
    public function create()
    {
        $categories = Category::where('es_subcategoria','0')->orderBy('id')->get();
        $subcategories = Category::where('es_subcategoria','1')->orderBy('id')->get();
        $unidades = Unit::orderBy('id')->get();
        $roles = RollProduct::orderBy('id')->get();
        
        return view('admin.products.create')->with(compact('categories','subcategories','unidades','roles'));   // formulario
    }
    
    public function store(Request $request)
    {
        // registrar nuevo producto en la bd
        //dd($request->all());   //imprime lo solicitado y termina ejecucion.
        
        //validaciones 
        
        $messages = [
            'name.required' => 'Es necesario ingresar el nombre del producto',
            'name.min' => 'El nombre del producto debe tener al menos 3 caracteres',
            'name.unique' => 'El nombre del producto que quieres capturar ya existe',
            'description.required' => 'La descripción corta es un campo obligatorio',
            'description.max' => 'La descripción corta solo admite hasta 200 caracteres',
            'unique' => 'Información repetida',
            'cantidad_prod.required' => 'Es necesario capturar la cantidad de producción. 
                                         Como ayuda, puedes tener estos casos: 
                                         1.- Unidad de producción = 1 si es una caja con varias cosas y vendes por caja.  
                                         2.- Si tienes una caja con 2000 piezas y vendes por pueza, entonces la cantidad de producción es 2000.   
                                         Recuerda que estos solo son ejemplos.'  
        ];
        
        $rules = [
            'name' => 'required|min:3',
            'description' => 'required|max:200',
            'name','id_unidad_prod','cantidad_prod','etiqueta_prod' => 'unique:products',
            'cantidad_prod' => 'required'    
        ];
        
        $this->validate($request,$rules,$messages);  
        
        $product = new Product();
        $product->name              = $request->input('name');
        $product->description       = $request->input('description');
        //$product->price             = $request->input('price');
        $product->long_description  = $request->input('long_description');
        $product->id_unidad_prod    = $request->input('id_unidad_prod');
        $product->cantidad_prod    = $request->input('cantidad_prod');
        $product->ancho_prod        = $request->input('ancho_prod');
        $product->etiqueta_prod    = $request->input('etiqueta_prod');
        $product->formula          = $request->input('formula');


        if (is_null($request->input('category_id')))
            $product->category_id = 1;
        else
            $product->category_id       = $request->input('category_id');      

        if (is_null($request->input('subcategory_id')))
            $product->subcategory_id = 1;
        else
            $product->subcategory_id       = $request->input('subcategory_id');      

        if (is_null($request->input('roll_id')))
            $product->roll_id = 1;
        else
            $product->roll_id       = $request->input('roll_id');      



        if ($request->input('activo') == 1)
            $product->activo    = $request->input('activo');
        else
            $company->activo = 0;   
        $product->save(); //insert en tabla productos


        Session::flash('message','El producto '.$product->name.' se ha agregado con exito.');
            
                  
        return redirect('/admin/products')->with('status', 'exito');
    }
    
    public function edit($id)
    {
        $categories = Category::where('es_subcategoria','0')->orderBy('id')->get();
        $subcategories = Category::where('es_subcategoria','1')->orderBy('id')->get();
        $unidades = Unit::orderBy('id')->get();
        $roles = RollProduct::orderBy('id')->get();

        $product = Product::find($id);
        return view('admin.products.edit')->with(compact('product','categories','subcategories','unidades','roles'));   // formulario
    }
    
    public function update(Request $request, $id)
    {
        // Editar producto en la bd
        //dd($request->all());   //imprime lo solicitado y termina ejecucion.
        
        //validaciones 
        
        $messages = [
            'name.required' => 'Es necesario ingresar el nombre del producto',
            'name.min' => 'El nombre del producto debe tener al menos 3 caracteres',
            'description.required' => 'La descripción corta es un campo obligatorio',
            'description.max' => 'La descripción corta solo admite hasta 200 caracteres',
            'cantidad_prod.required' => 'Es necesario capturar la cantidad de producción. 
                                         Como ayuda, puedes tener estos casos: 
                                         1.- Unidad de producción = 1 si es una caja con varias cosas y vendes por caja.  
                                         2.- Si tienes una caja con 2000 piezas y vendes por pueza, entonces la cantidad de producción es 2000.   
                                         Recuerda que estos solo son ejemplos.'
            
            
        ];
        
        $rules = [
            'name' => 'required|min:3',
            'description' => 'required|max:200',
            'cantidad_prod' => 'required'  
          
            
        ];
        
        $this->validate($request,$rules,$messages);  
        
        $product = Product::find($id);
        $product->name              = $request->input('name');
        $product->description       = $request->input('description');
//        $product->price             = $request->input('price');
        $product->long_description  = $request->input('long_description');

        $product->id_unidad_prod    = $request->input('id_unidad_prod');
        $product->cantidad_prod    = $request->input('cantidad_prod');
        $product->ancho_prod       = $request->input('ancho_prod');
        $product->etiqueta_prod    = $request->input('etiqueta_prod');

        $product->category_id       = $request->input('category_id');
        $product->subcategory_id    = $request->input('subcategory_id');
        $product->formula          = $request->input('formula');
        $product->roll_id           = $request->input('roll_id');
        $product->activo            = $request->input('activo');
        if ($product->activo <> 1)
            $product->activo = 0;
        else            
            $product->activo = 1;
        $product->save(); //update en tabla productos


        Session::flash('message','El producto '.$product->name.' se ha modificado con exito.');
            

            
        return redirect('/admin/products')->with('status', 'exito');
    }
    
    
    public function destroy($id)
    {
        // registrar nuevo producto en la bd
        //dd($request->all());   //imprime lo solicitado y termina ejecucion.
        $product = Product::find($id);
        $nomprod = $product->name;
        
        $images = ProductImage::where('product_id',$id);
        $imagenes = ProductImage::where('product_id',$id)->count();

        $apc = almproducts::where('id_product',$id)->count();

        
        if ($apc == 0 ) {

            if($imagenes > 0){

                    $images->each(function ($images){
                    if (substr($images->image,0,4)==="http")  // Si empieza con http o sea que es link
                    {
                        $deleted = true;
                     }else {
                        if ($images->image ==="default.png"){
                             $deleted = true;
                        }else{
                             $fullPath = public_path() . '/images/products/' . $images->image;
                             $deleted = File::delete($fullPath);
                        }
                    }

                    });

                    $images->where('product_id',$id)->delete();

                }

            $product->delete(); //delete en tabla productos

            Session::flash('message','Se ha borrado exitosamente el producto '.$nomprod.'.');
            return redirect('/admin/products')->with('status', 'exito');
        }else {
            Session::flash('message','El producto '.$nomprod.' no se puede borrar porque tiene movimientos en almacen.');
            return redirect('/admin/products')->with('status', 'noexito');

        }

                    
        return back();
    }
}
