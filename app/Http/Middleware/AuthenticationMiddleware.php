<?php

namespace App\Http\Middleware;

use App\Http\Controllers\AuthenticationController;
use Closure;
use Firebase\JWT\JWT;

class AuthenticationMiddleware
{
    public function handle($request, Closure $next)
    {
        $origin = $request->input('origin');
        $token = $request->header('authorization');

        if (!AuthenticationMiddleware::encryptOrDecrypt('decrypt', $token, $origin)) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Unauthorized'
            ], 401);
        }

        return $next($request);
    }

    public static function encryptOrDecrypt($action, $string) {
        if ($action == 'encrypt') {
            return base64_encode(JWT::encode(
                $string,
                AuthenticationController::KEY
            ));
        } else if ($action == 'decrypt') {
            return JWT::sign(
                base64_decode($string),
                AuthenticationController::KEY
            );
        }

        return false;
    }

}
