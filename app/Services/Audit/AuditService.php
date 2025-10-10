<?php

namespace App\Services\Audit;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuditService
{
    /**
     * Registra la navegación del usuario.
     */
   
    public function logNavigation(Request $request, $idu, $type = 1){
        /* Type: 
                1 = Navegación web
                2 = Navegación App
        */
        $timestamp = date('Y-m-d H:i:s');

        DB::transaction(function () use ($idu, $request, $timestamp, $type) {
            $data = [
                'iduser'        => $idu,
                'url'           => $request->fullUrl(),
                'metodo'        => $request->method(),
                'ip_address'    => $request->ip(),
                'user_agent'    => $request->header('User-Agent'),
                'created_at'    => $timestamp,
                'type'          => $type
            ];
            
            DB::table('tb_users_navegation')->insert($data);
        });
    }

    /**
     * Marca última actividad del usuario (si quieres mantenerlo aquí).
     */
    public function touchLastActivity($user)
    {
        $user->last_activity = date('Y-m-d H:i:s');
        $user->save();
    }
}
