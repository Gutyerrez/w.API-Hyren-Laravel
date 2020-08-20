<?php

namespace App\Http\Middleware;

use App\Http\Controllers\AuthenticationController;
use Closure;

class AuthenticationMiddleware
{
    public function handle($request, Closure $next)
    {
        // $token = $request->header('authorization');

        // if (!AuthenticationMiddleware::encryptOrDecrypt('decrypt', $token)) {
        //     return response()->json([
        //         'status' => 'fail',
        //         'message' => 'Unauthorized'
        //     ], 401);
        // }

        return $next($request);
    }

    /**
     * Fazer isso aqui funcionar
     */

    public static function encryptOrDecrypt($action, $string) {
        
        if ($action == 'encrypt') {
            return null;
        } else if ($action == 'decrypt') {
            return null;
        }

        return false;
    }

}
