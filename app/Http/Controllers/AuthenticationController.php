<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Middleware\AuthenticationMiddleware;

class AuthenticationController extends Controller
{

    public static function store(Request $request)
    {
        $payload = json_encode([
            'time' => microtime(true),
            'duration' => 60000
        ]);

        $encrypted = AuthenticationMiddleware::encryptOrDecrypt('encrypt', $payload);

        return response()->json([
            'status' => 'ok',
            'access_token' => $encrypted
        ], 200);
    }

}
