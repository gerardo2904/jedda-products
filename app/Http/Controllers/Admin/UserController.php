<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.users.index')->with(compact('users'));   // listado  
    }
    
    public function create()
    {
        return view('admin.users.create');   // formulario
    }
    
    public function store(Request $request)
    {
        // registrar nuevo producto en la bd
        //dd($request->all());   //imprime lo solicitado y termina ejecucion.
        
        //validaciones 
        
        $messages = [
            'name.required' => 'Es necesario ingresar el nombre',
            'name.min' => 'El nombre de usuario debe tener al menos 3 caracteres'
        ];
        
        $rules = [
        	'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|max:255|unique:users'


        /*    'description' => 'required|max:200',
            'price' => 'required|numeric|min:0'  */
            
        ];
        
        $this->validate($request,$rules,$messages);  
        
        $user = new User();
        $user->name          = $request->input('name');
        $user->email         = $request->input('email');
        $user->password      = bcrypt($request->input('password'));
        $user->permisos      = $request->input('permisos');
        $user->empresa_id    = $request->input('empresa_id');
        
        if ($request->input('activo') == 1)
        	$user->activo    = $request->input('activo');
        else
        	$user->activo = 0;

        $user->save(); //insert en tabla productos
            
        return redirect('/admin/users');
    }
    
    public function edit($id)
    {
        
        $user = User::find($id);
        return view('admin.users.edit')->with(compact('user'));   // formulario
    }
    
    public function update(Request $request, $id)
    {
        // Editar producto en la bd
        //dd($request->all());   //imprime lo solicitado y termina ejecucion.
        
        //validaciones 
        
        $messages = [
            'name.required' => 'Es necesario ingresar el nombre',
            'name.min' => 'El nombre de usuario debe tener al menos 3 caracteres'
        /*    'description.required' => 'La descripción corta es un campo obligatorio',
            'description.max' => 'La descripción corta solo admite hasta 200 caracteres',
            'price.required' => 'Es obligatorio definir precio del producto',
            'price.numeric' => 'Ingrese un precio válido',
            'price.min' => 'No se admiten valores negativos'
          */  
        ];
        
        $rules = [
        	'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|max:255|unique:users'


        /*    'description' => 'required|max:200',
            'price' => 'required|numeric|min:0'  */
            
        ];
        
        $this->validate($request,$rules,$messages);  
        
        
        $user = User::find($id);
        $user->name          = $request->input('name');
        $user->email         = $request->input('email');
        $user->password      = $request->input('password');
        $user->permisos      = $request->input('permisos');
        $user->empresa_id    = $request->input('empresa_id');
        
		$user->activo    = $request->input('activo');

		if ($user->activo <> 1)
			$user->activo = 0;
		else			
			$user->activo = 1;

        //$company->activo    = $request->input('activo');
        $user->save(); //update en tabla productos


            
        return redirect('/admin/users');
    }
    
    
    public function destroy($id)
    {
        // registrar nueva compañia en la bd
        //dd($request->all());   //imprime lo solicitado y termina ejecucion.
        $user = User::find($id);

        $nomusr = $user->name;
        $images = UserImage::where('user_id',$id);
        $imagenes = UserImage::where('user_id',$id)->count();

        
            if($imagenes > 0){

                $images->each(function ($images){
                if (substr($images->image,0,4)==="http")  // Si empieza con http o sea que es link
                {
                    $deleted = true;
                 }else {
                    if ($images->image ==="user-default.png"){
                         $deleted = true;
                    }else{
                            $fullPath = public_path() . '/images/users/' . $images->image;
                         $deleted = File::delete($fullPath);
                    }
                }

                });

                $images->where('user_id',$id)->delete();
            }

        $user->delete(); //delete en tabla Users

        Session::flash('message','Se ha borrado exitosamente el usuario '.$nomusr.'.');
        return redirect('/admin/users')->with('status', 'exito');

            
        return back();
    }
}
