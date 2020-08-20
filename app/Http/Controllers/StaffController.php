<?php

namespace App\Http\Controllers;

use App\Extensions\Permission\Group;
use App\Models\Group as GroupModel;
use Illuminate\Database\QueryException;

class StaffController extends Controller
{

    public function index()
    {
        try {
            $users = GroupModel::with('users')
                ->where('priority', '>=', Group::HELPER['priority'])
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
