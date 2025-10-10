<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

use App\Services\Audit\AuditService;

class CheckUserStatus
{
    
    protected $audit;

    public function __construct(AuditService $audit)
    {
        $this->audit = $audit;
    }

    /*
        30-01-2024
        Creado por Sesmas para validar cuando un usuario esta inactivo y es necesario sacarlo de los usuarios
    */
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            Auth::logout(); // Cierra la sesión

            // Si es una petición AJAX (Axios o cualquier otra librería)
            if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'status' => 'no',
                    'message' => 'Tu sesión ha expirado. Por favor, inicia sesión nuevamente.',
                ], 401); // Código HTTP 401: No autorizado
            }
            return redirect('/user/login');
        }

        $user = Auth::user(); // Obtiene el usuario autenticado
        try {
            if($user->id != 1){
                $this->audit->touchLastActivity($user);
                $this->audit->logNavigation($request, $user->id);
            }
        } catch (\Exception $e) {
            // Registra el error en los logs
            // \Log::error('Error al registrar la navegación del usuario: ' . $e->getMessage());
        }

        // Verifica si el usuario está inactivo
        if ($user->active == 0) {
            Auth::logout(); // Cierra la sesión
            return redirect('/user/login');
        }
    
        return $next($request);
    }
}
