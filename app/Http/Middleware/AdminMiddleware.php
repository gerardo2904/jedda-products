<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //Checar si ya inicio sesion el usuario, en caso de que no, se redirige a login
        /* if (!auth()->check()){
            return redirect('/login');
        } */
        
        //Si no es administrador, se redirige a login
    /*    if (!auth()->user()->admin){
            return redirect('/login');
        }  */
        
        //Si no es administrador, se redirige a la pagina que quiere ver (productos, home, etc)
        // La autentificacion ahora se le manda al middleware como parametro en la ruta (web)
        if (auth()->user()->permisos != '0'){
            return redirect('/');
        }
        
        
        return $next($request);
    }
}
