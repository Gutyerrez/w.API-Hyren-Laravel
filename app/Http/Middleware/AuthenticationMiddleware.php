<?php

namespace App\Http\Middleware;

use App\Http\Controllers\AuthenticateController;
use Closure;

use Firebase\JWT\JWT;

class AuthenticationMiddleware
{
    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    public static function encryptOrDecrypt($action, $string, $origin = null) {
        if ($action == 'encrypt') {
            $output = JWT::encode($string, AuthenticateController::KEY);

            return base64_encode($output);
        } else if ($action == 'decrypt') {
            if (empty($string)) {
                return false;
            }

            $encoded = base64_decode($string);

            $payload = json_decode(JWT::decode($encoded, AuthenticateController::KEY));

            $payload_origin = $payload['origin'];

            if ($payload_origin != $origin) {
                return false;
            }

            $duration = $payload['time'] + $payload['duration'];

            $current_time = microtime(false);

            if ($current_time > $duration) {
                return false;
            }

            return true;
        }

        return false;
    }

}
