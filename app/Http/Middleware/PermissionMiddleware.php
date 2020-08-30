<?php

namespace App\Http\Middleware;

use Closure;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        if (Auth::guest()) {
            return redirect('/login');
        }

        if (! $request->user()->can($permission)) {
            if ($request->ajax()) {
               //$mesage='No tiene permisos para acceder, contacte con su administrador';
                ajaxError();
            }else{
            $error=403;
            return redirect('/error/'.$error);
            }
        }

        return $next($request);
    }
}
