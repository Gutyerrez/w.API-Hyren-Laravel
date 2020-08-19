<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{
    public function index()
    {
        $users = Group::with('users')->get([
            'display_name', 'color'
        ]);

        return response()->json($users);
    }
}
