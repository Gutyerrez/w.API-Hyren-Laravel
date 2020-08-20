<?php

namespace App\Http\Middleware;

use App\Http\Controllers\AuthenticationController;
use Closure;

class AuthenticationMiddleware
{
    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    public static function encryptOrDecrypt($action, $string, $origin = null) {
        $output = false;
        $encrypt_method = 'AES-256-CBC';
        $key = hash('sha256', AuthenticationController::KEY);

        if ($action == 'encrypt') {
            $ivlen = openssl_cipher_iv_length($encrypt_method);
            $iv = openssl_random_pseudo_bytes($ivlen);

            $output = openssl_encrypt(
                $string,
                $encrypt_method,
                $key,
                0,
                $iv
            );

            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            if (empty($string)) {
                return $output;
            }

            $encoded = base64_decode($string);

            $payload = openssl_decrypt($encoded, $encrypt_method, $key);

            $payload_origin = $payload['origin'];

            if ($payload_origin != $origin) {
                return $output;
            }

            $duration = $payload['time'] + $payload['duration'];

            $current_time = microtime(false);

            if ($current_time > $duration) {
                return $output;
            }

            return true;
        }

        return $output;
    }

}
