<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Misc\Utils\MojangAPI;

class MojangController extends Controller
{

    public function store(Request $request) {
        $username = $request->input('username');
        $password = $request->input('password');

        return MojangAPI::authenticate($username, $password);
    }

}
