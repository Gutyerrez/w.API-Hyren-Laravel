<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Misc\Discord\DiscordAPI;

class DiscordController extends Controller
{

    public function store(Request $request)
    {
        $code = $request->query('code');

        if (empty($code)) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Please provide an discord code'
            ]);
        }

        return DiscordAPI::fetchUserByCode($code);
    }
}
