<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Client;
use App\ClientImage;
Use App\Ingreso;
Use App\Venta;
Use App\Production_Order;
use File;

Use Session;
Use Redirect;


class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::paginate(10);
        return view('admin.clients.index')->with(compact('clients'));   // listado  
    }
    
    public function create()
    {
        return view('admin.clients.create');   // formulario
    }
    
    public function store(Request $request)
    {
        // registrar nuevo producto en la bd
        //dd($request->all());   //imprime lo solicitado y termina ejecucion.
        
        //validaciones 
        
        $messages = [
            'name.required' => 'Es necesario ingresar el nombre',
            'name.min' => 'El nombre de usuario debe tener al menos 3 caracteres',
            'email.unique'=>'El email ya esta dado de alta en la base de datos'
        ];
        
        $rules = [
        	'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|max:255|unique:clients'


        /*    'description' => 'required|max:200',
            'price' => 'required|numeric|min:0'  */
            
        ];
        
        $this->validate($request,$rules,$messages);  
        
        $client = new Client();
        $client->name          = $request->input('name');
        $client->rfc           = $request->input('rfc');
        $client->address       = $request->input('address');
        $client->city          = $request->input('city');
        $client->cp            = $request->input('cp');
        $client->tel           = $request->input('tel');
        $client->email         = $request->input('email');

        if ($request->input('es_proveedor') == 1)
            $client->es_proveedor    = $request->input('es_proveedor');
        else
            $client->es_proveedor = 0;

                
        if ($request->input('activo') == 1)
        	$client->activo    = $request->input('activo');
        else
        	$client->activo = 0;

        $client->save(); //insert en tabla productos

        $cli = Client::where('name',$client->name)->first();
        $idc=$cli->id;

        // Imagen por default....

        $file  = 'user-default.png';
        $path = public_path() . '/images/clients';
        //$path = public_path();
        $fileName = uniqid() . $file;
        //$moved = $file->copy($path.'/'.$file, $path.'/'.$fileName);
        $moved = \File::copy($path.'/'.$file, $path.'/'.$fileName);
        
        // crear 1 registro en la tabla category_images
        if ($moved){
            $clientImage = new ClientImage();
            $clientImage->image = $fileName;
            // $productImage->featured = false;   // Ya esta en la definicion de la tabla esta condicion, por eso se comenta.
            $clientImage->client_id = $idc;
            $clientImage->featured = 1;
            $clientImage->save();  //INSERT
        }

            
        return redirect('/admin/clients');
    }
    
    public function edit($id)
    {
        
        $client = Client::find($id);
        return view('admin.clients.edit')->with(compact('client'));   // formulario
    }
    
    public function update(Request $request, $id)
    {
        $client = Client::find($id);
        // Editar producto en la bd
        //dd($request->all());   //imprime lo solicitado y termina ejecucion.
        
        //validaciones 
        
        $messages = [
            'name.required' => 'Es necesario ingresar el nombre',
            'name.min' => 'El nombre de usuario debe tener al menos 3 caracteres',
            'email.unique'=>'El email ya esta dado de alta en la base de datos'
        ];
        
        $rules = [
        	'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|max:255|unique:clients,email,'. $client->id,  //para evitar 
                                                                                        // confictos con
                                                                                        // edicion cuando
                                                                                        // un campo es unique 


        /*    'description' => 'required|max:200',
            'price' => 'required|numeric|min:0'  */
            
        ];
        
        $this->validate($request,$rules,$messages);  
        
        
        
        $client->name          = $request->input('name');
        $client->rfc           = $request->input('rfc');
        $client->address       = $request->input('address');
        $client->city          = $request->input('city');
        $client->cp            = $request->input('cp');
        $client->tel           = $request->input('tel');
        $client->email         = $request->input('email');
        
        $client->es_proveedor  = $request->input('es_proveedor');

        if ($client->es_proveedor <> 1)
            $client->es_proveedor = 0;
        else            
            $client->es_proveedor = 1;


		$client->activo    = $request->input('activo');

		if ($client->activo <> 1)
			$client->activo = 0;
		else			
			$client->activo = 1;

        //$company->activo    = $request->input('activo');
        $client->save(); //update en tabla productos


            
        return redirect('/admin/clients');
    }
    
    
    public function destroy($id)
    {
        // registrar nueva compañia en la bd
        //dd($request->all());   //imprime lo solicitado y termina ejecucion.
        $client = Client::find($id);

        $nomcli = $client->name;
        $images = ClientImage::where('client_id',$id);
        $imagenes = ClientImage::where('client_id',$id)->count();

        $ing  = Ingreso::where('idproveedor',$id)->count();
        $vta  = Venta::where('idcliente',$id)->count();
        $pro  = Production_Order::where('idcliente',$id)->count();


        if ($ing==0 && $vta == 0 && $pro ==0) {
            if($imagenes > 0){

                $images->each(function ($images){
                if (substr($images->image,0,4)==="http")  // Si empieza con http o sea que es link
                {
                    $deleted = true;
                 }else {
                    if ($images->image ==="user-default.png"){
                         $deleted = true;
                    }else{
                            $fullPath = public_path() . '/images/clients/' . $images->image;
                         $deleted = File::delete($fullPath);
                    }
                }

                });

                $images->where('client_id',$id)->delete();
            }

        $client->delete(); //delete en tabla Clients

        Session::flash('message','Se ha borrado exitosamente el cliente '.$nomcli.'.');
        return redirect('/admin/clients')->with('status', 'exito');
        }else{
             Session::flash('message','El Cliente / Proveedor '.$nomcli.' no se puede borrar porque tiene movimientos generados.');
            return redirect('/admin/clients')->with('status', 'noexito');
        }
            
        return back();
    }
}
