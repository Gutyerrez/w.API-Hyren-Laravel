<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        $users = Group::with('users')->get();

        return response()->json($users);
    }
}
