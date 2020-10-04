<?php

namespace App\Http\Controllers;

use App\Extensions\Permission\Group as PermissionGroup;
use App\Models\Group;
use Illuminate\Database\QueryException;

class StaffController extends Controller
{

    public function index()
    {
        try {
            $users = Group::with('users')
                ->where('priority', '>=', PermissionGroup::HELPER['priority'])
                ->get([
                    'name', 'display_name', 'color',
                ]);

            return response()->json([
                'status' => 'ok',
                'payload' => $users
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Internal server error.'
            ]);
        }
    }

}
