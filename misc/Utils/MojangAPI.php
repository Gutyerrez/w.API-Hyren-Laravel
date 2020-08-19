<?php

namespace Misc\Utils;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Http;

class MojangAPI
{
    const API_END_POINT = 'https://authserver.mojang.com';

    public static function authenticate($username, $password) {
        try {
            $response = Http::post(
                MojangAPI::API_END_POINT . '/authenticate',
                [
                    'agent' => [
                        'name' => 'Minecraft',
                        'version' => 1
                    ],
                    'username' => $username,
                    'password' => $password,
                    'requestUser' => true
                ]
            );

            $data = $response->json();

            if (empty($data['user'])) {
                return response([
                    'status' => 'fail',
                    'message' => 'Invalid username or password'
                ], 401);
            }

            $user = $data['selectedProfile'];

            return response([
                'status' => 'ok',
                'payload' => [
                    "username" => $user['name'],
                    "id" => UUID::fromString($user['id'])
                ]
            ], 200);
        } catch (HttpResponseException $e) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Internal server error'
            ], 500);
        }
    }

}
