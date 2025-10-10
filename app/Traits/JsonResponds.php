<?php
namespace App\Traits;

trait JsonResponds
{
    protected function success($message = 'Operación realizada con éxito', $data = null)
    {
        return response()->json([
            'status' => 'ok',
            'message' => $message,
            'data' => $data,
        ]);
    }

    protected function error($message = 'Ocurrió un error', $errors = null)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors,
        ]);
    }
}
