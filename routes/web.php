<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'TestController@welcome');


Route::get('/prueba', function () {
    return 'Ruta de prueba';
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/products/{id}','ProductController@show');  
Route::get('/categories/{id}','CategoryController@show');  
Route::get('/companies/{id}','CompanyController@show');  
Route::get('/clients/{id}','ClientController@show');  
Route::get('/users/{id}','UserController@show');  

Route::post('/cart','CartDetailController@store');
Route::delete('/cart','CartDetailController@destroy');

Route::post('/order','CartController@update');

Route::get('/almproducts','Admin\AlmproductController@index');  //listado
    
Route::get('/import', 'Admin\ImportController@import');

Route::get('phpinfo', function () {
    return phpinfo();
});


Route::middleware(['auth','admin'])->group(function(){
    Route::resource('compras/ingreso','IngresoController');
    Route::resource('ventas/venta','VentaController');
    Route::resource('productionorder/production','ProductionOrderController');
});

Route::middleware(['auth','admin'])->prefix('admin')->namespace('Admin')->group(function(){
    
        //con prefix('admin') se elimina el /admin/ antes del nombre de las rutas de abajo...
		// ejemplo: Si no tuviera prefix('admin') se tendria que poner la linea asi:
		// Route::get('/admin/products','Admin\ProductController@index');  //listado
		
		//con namespace('Admin') se elimina el Admin\ antes del nombre del controlador.
		//ejemplo: Si no tuviera namespace('Admin'), se tendria que poner la linea asi:
		// Route::get('/products','Admin\ProductController@index');  //listado
    
        Route::get('/products','ProductController@index');  //listado
        Route::get('/products/create','ProductController@create');  //Formulario de nuevos productos
        Route::post('/products','ProductController@store');  //Registra nuevos productos
        Route::get('/products/{id}/edit','ProductController@edit');  //Formulario edicion
        Route::post('/products/{id}/edit','ProductController@update');  //Actualizar
        Route::delete('/products/{id}','ProductController@destroy');  //Form para eliminar
		
        Route::get('/products/{id}/images','ImageController@index');  // Listado y formulario
        Route::post('/products/{id}/images', 'ImageController@store'); //Registrar nuevas fotos
        Route::delete('/products/{id}/images','ImageController@destroy');  //Form para eliminar
        Route::get('/products/{id}/images/select/{image}','ImageController@select'); //destacar imagen


        
        Route::get('/categories','CategoryController@index');  //listado
        Route::get('/categories/create','CategoryController@create');  //Formulario de nuevas categorias
        Route::post('/categories','CategoryController@store');  //Registra nuevas categorias
        Route::get('/categories/{id}/edit','CategoryController@edit');  //Formulario edicion
        Route::post('/categories/{id}/edit','CategoryController@update');  //Actualizar
        Route::delete('/categories/{id}','CategoryController@destroy');  //Form para eliminar

        Route::get('/categories/{id}/images','ImageCategoryController@index');  // Listado y formulario
        Route::post('/categories/{id}/images', 'ImageCategoryController@store'); //Registrar nuevas fotos
        Route::delete('/categories/{id}/images','ImageCategoryController@destroy');  //Form para eliminar
        Route::get('/categories/{id}/images/select/{image}','ImageCategoryController@select'); //destacar imagen		

    
    	Route::get('/companies','CompanyController@index');  //listado
        Route::get('/companies/create','CompanyController@create');  //Formulario de nuevas compañias
        Route::post('/companies','CompanyController@store');  //Registra nuevos compañias
        Route::get('/companies/{id}/edit','CompanyController@edit');  //Formulario edicion
        Route::post('/companies/{id}/edit','CompanyController@update');  //Actualizar
        Route::delete('/companies/{id}','CompanyController@destroy');  //Form para eliminar

        Route::get('/companies/{id}/images','ImageCompanyController@index');  // Listado y formulario
        Route::post('/companies/{id}/images', 'ImageCompanyController@store'); //Registrar nuevas fotos
        Route::delete('/companies/{id}/images','ImageCompanyController@destroy');  //Form para eliminar
        Route::get('/companies/{id}/images/select/{image}','ImageCompanyController@select'); //destacar imagen




        Route::get('/users','UserController@index');  //listado
        Route::get('/users/create','UserController@create');  //Formulario de nuevos usuarios
        Route::post('/users','UserController@store');  //Registra nuevos usuarios
        Route::get('/users/{id}/edit','UserController@edit');  //Formulario edicion
        Route::post('/users/{id}/edit','UserController@update');  //Actualizar
        Route::delete('/users/{id}','UserController@destroy');  //Form para eliminar

        Route::get('/users/{id}/images','ImageUserController@index');  // Listado y formulario
        Route::post('/users/{id}/images', 'ImageUserController@store'); //Registrar nuevas fotos
        Route::delete('/users/{id}/images','ImageUserController@destroy');  //Form para eliminar
        Route::get('/users/{id}/images/select/{image}','ImageUserController@select'); //destacar imagen


        Route::get('/clients','ClientController@index');  //listado
        Route::get('/clients/create','ClientController@create');  //Formulario de nuevos clientes
        Route::post('/clients','ClientController@store');  //Registra nuevos usuarios
        Route::get('/clients/{id}/edit','ClientController@edit');  //Formulario edicion
        Route::post('/clients/{id}/edit','ClientController@update');  //Actualizar
        Route::delete('/clients/{id}','ClientController@destroy');  //Form para eliminar

        Route::get('/clients/{id}/images','ImageClientController@index');  // Listado y formulario
        Route::post('/clients/{id}/images', 'ImageClientController@store'); //Registrar nuevas fotos
        Route::delete('/clients/{id}/images','ImageClientController@destroy');  //Form para eliminar
        Route::get('/clients/{id}/images/select/{image}','ImageClientController@select'); //destacar imagen

});




