<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Misc\Mojang\MojangAPI;

class MojangController extends Controller
{

    public function store(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        $response = MojangAPI::authenticate($username, $password);

        if ($response->status !== 'ok') {
            return $response;
        }

        $payload = $response->payload;

        try {
            $user = User::where('id', $payload->id)
                ->first();

            if ($user === null) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'User not found'
                ]);
            }

            return $response;
        } catch (QueryException $e) {
            return response()->json([
                'status' => 'fail',
                'message' => INTERNAL_SERVER_ERROR
            ], 500);
        }
    }
}
