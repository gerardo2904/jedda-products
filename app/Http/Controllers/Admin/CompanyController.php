<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Company;
use App\CompanyImage;
use File;

Use Session;
Use Redirect;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::paginate(10);
        return view('admin.companies.index')->with(compact('companies'));   // listado  
    }
    
    public function create()
    {
        return view('admin.companies.create');   // formulario
    }
    
    public function store(Request $request)
    {
        // registrar nuevo producto en la bd
        //dd($request->all());   //imprime lo solicitado y termina ejecucion.
        
        //validaciones 
        
        $messages = [
            'name.required' => 'Es necesario ingresar el nombre de compañia',
            'name.min' => 'El nombre de compañia debe tener al menos 3 caracteres'
        ];
        
        $rules = [
            'name' => 'required|min:3'
        ];
        
        $this->validate($request,$rules,$messages);  
        
        $company = new Company();
        $company->name      = $request->input('name');
        $company->rfc       = $request->input('rfc');
        $company->address   = $request->input('address');
        $company->city      = $request->input('city');
        $company->cp        = $request->input('cp');
        $company->tel       = $request->input('tel');
        $company->email     = $request->input('email');
        $company->contact   = $request->input('contact');
        if ($request->input('activo') == 1)
        	$company->activo    = $request->input('activo');
        else
        	$company->activo = 0;	
        $company->save(); //insert en tabla productos

        $com = Company::where('name',$company->name)->first();
        $idc=$com->id;

        // Imagen por default....

        $file  = 'company-default.png';
        $path = public_path() . '/images/companies';
        //$path = public_path();
        $fileName = uniqid() . $file;
        //$moved = $file->copy($path.'/'.$file, $path.'/'.$fileName);
        $moved = \File::copy($path.'/'.$file, $path.'/'.$fileName);
        
        // crear 1 registro en la tabla category_images
        if ($moved){
            $companyImage = new CompanyImage();
            $companyImage->image = $fileName;
            // $productImage->featured = false;   // Ya esta en la definicion de la tabla esta condicion, por eso se comenta.
            $companyImage->company_id = $idc;
            $companyImage->featured = 1;
            $companyImage->save();  //INSERT
        }

            
        return redirect('/admin/companies');
    }
    
    public function edit($id)
    {
        
        $company = Company::find($id);
        return view('admin.companies.edit')->with(compact('company'));   // formulario
    }
    
    public function update(Request $request, $id)
    {
        // Editar producto en la bd
        //dd($request->all());   //imprime lo solicitado y termina ejecucion.
        
        //validaciones 
        
        $messages = [
            'name.required' => 'Es necesario ingresar el nombre de compañia',
            'name.min' => 'El nombre de compañia debe tener al menos 3 caracteres'
        /*    'description.required' => 'La descripción corta es un campo obligatorio',
            'description.max' => 'La descripción corta solo admite hasta 200 caracteres',
            'price.required' => 'Es obligatorio definir precio del producto',
            'price.numeric' => 'Ingrese un precio válido',
            'price.min' => 'No se admiten valores negativos'
          */  
        ];
        
        $rules = [
            'name' => 'required|min:3'
        /*    'description' => 'required|max:200',
            'price' => 'required|numeric|min:0'  */
            
        ];
        
        $this->validate($request,$rules,$messages);  
        
        
        $company = Company::find($id);
        $company->name      = $request->input('name');
        $company->rfc       = $request->input('rfc');
        $company->address   = $request->input('address');
        $company->city      = $request->input('city');
        $company->cp        = $request->input('cp');
        $company->tel       = $request->input('tel');
        $company->email     = $request->input('email');
        $company->contact   = $request->input('contact');
		$company->activo    = $request->input('activo');

		if ($company->activo <> 1)
			$company->activo = 0;
		else			
			$company->activo = 1;

        //$company->activo    = $request->input('activo');
        $company->save(); //update en tabla productos


            
        return redirect('/admin/companies');
    }
    
    
    public function destroy($id)
    {
        // registrar nueva compañia en la bd
        //dd($request->all());   //imprime lo solicitado y termina ejecucion.
        $company = Company::find($id);

        $nomcom = $company->name;
        $images = CompanyImage::where('company_id',$id);
        $imagenes = CompanyImage::where('company_id',$id)->count();

        
            if($imagenes > 0){

                $images->each(function ($images){
                if (substr($images->image,0,4)==="http")  // Si empieza con http o sea que es link
                {
                    $deleted = true;
                 }else {
                    if ($images->image ==="company-default.png"){
                         $deleted = true;
                    }else{
                            $fullPath = public_path() . '/images/companies/' . $images->image;
                         $deleted = File::delete($fullPath);
                    }
                }

                });

                $images->where('company_id',$id)->delete();
            }

            

        $company->delete(); //delete en tabla Companies

        Session::flash('message','Se ha borrado exitosamente la compañia '.$nomcom.'.');
        return redirect('/admin/companies')->with('status', 'exito');

            
        return back();
    }}
