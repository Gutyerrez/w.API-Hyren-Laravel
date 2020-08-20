<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Middleware\AuthenticationMiddleware;

class AuthenticationController extends Controller
{
    const KEY = 'HYREN-APPLICATION-8768-144534578-48788-12345787';

    public static function store(Request $request)
    {
        $origin = $request->input('origin');

        if (empty($origin)) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Please inform origin'
            ], 400);
        }

        $payload = json_encode([
            'origin' => $origin,
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
