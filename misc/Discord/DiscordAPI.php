<?php

namespace Misc\Discord;

use Illuminate\Support\Facades\Http;

class DiscordAPI
{
    const API_END_POINT = 'https://authserver.mojang.com';

    // Discord credentials
    const CLIENT_ID = 734682082915254304;
    const CLIENT_SECRET = 'xl_ewNyuqABL8-PWTwPkdnzOzPE5Uaet';

    // Discord redirect URI
    const REDIRECT_URI = 'https://hyren.net/discord';

    private static function exchangeCode(String $code) {
        $response = Http::post(
            DiscordAPI::API_END_POINT . '/oauth2/token',
            [
                'data' => [
                    'client_id' => DiscordAPI::CLIENT_ID,
                    'client_secret' => DiscordAPI::CLIENT_SECRET,
                    'grant_type' => 'authorization_code',
                    'code' => $code,
                    'redirect_url' => DiscordAPI::REDIRECT_URI,
                    'scope' => 'identify email connections',
                ],
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ]
            ]
        );

        return $response->json();
    }

    private static function authorize(String $token_type, String $access_token) {
        $response = Http::get(
            DiscordAPI::API_END_POINT . '/users/@me',
            [
                'headers' => [
                    'Authorization' => `${token_type} ${access_token}`,
                ]
            ]
        );

        return $response->json();
    }

    public static function fetchUserByCode(String $code) {
        $exchanged = json_decode(DiscordAPI::exchangeCode($code));

        return DiscordAPI::authorize(
            $exchanged['token_type'],
            $exchanged['access_token']
        );
    }

}
