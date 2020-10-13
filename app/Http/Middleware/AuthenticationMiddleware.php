<?php

namespace App\Http\Middleware;

use App\Http\Controllers\AuthenticationController;
use App\Models\AccessToken;
use Closure;
use DateTime;
use Exception;
use Misc\Utils\StringUtils;

class AuthenticationMiddleware
{
    public function handle($request, Closure $next)
    {
        return $next($request);

        $token = $request->header('authorization');

        if (!AuthenticationMiddleware::encryptOrDecrypt('decrypt', $token)) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Unauthorized'
            ], 401);
        }

        return $next($request);
    }

    public static function encryptOrDecrypt($action, $string) {
        $token_type = 'Bearer';

        if ($action == 'encrypt') {
            $generated = StringUtils::randomString(52);

            $access_token = AccessToken::create([
                'token_type' => $token_type,
                'access_token' => $generated,
                'due_at' => date(DateTime::ISO8601, round(microtime(true)) + 60)
            ]);

            return $access_token;
        } else if ($action == 'decrypt') {
            try {
                $token = explode(' ', $string);

                $request_token_type = $token[0];
                $request_access_token = $token[1];

                $access_token = AccessToken::where('token_type', $request_token_type)
                    ->where('access_token', $request_access_token)
                    ->first();

                if (empty($access_token)) {
                    return false;
                }

                $current_date = new DateTime();
                $token_due_at = new DateTime($access_token['due_at']);

                if ($current_date > $token_due_at) {
                    return false;
                }

                return $access_token['token_type'] == $token_type;
            } catch (Exception $ignored) {}
        }

        return false;
    }

}
