<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
             // Verificar si el usuario está autenticado
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                // Si es una solicitud AJAX, devolver un error 401
                return response('Unauthorized.', 401);
            } else {
                // Si no es una solicitud AJAX, redirigir al login
                return redirect()->guest('/user/login');
            }
        }

        return $next($request);
    }
}
