<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    public function index(Request $request)
    {
        $offset = $request->query('offset', 0);
        $page = $request->query('page', 10);

        try {
            $users = User::skip($offset)->take($page)->get();

            return response()->json([
                'status' => 'ok',
                'payload' => $users
            ], 200);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 'fail',
                'message' => INTERNAL_SERVER_ERROR
            ], 500);
        }
    }

    public function show(Request $request, $user_id)
    {
        if (empty($user_id)) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Please inform user id'
            ], 400);
        }

        try {
            $user = User::where('id', $user_id)->first();

            return response()->json([
                'status' => 'ok',
                'payload' => $user
            ], 200);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 'fail',
                'message' => INTERNAL_SERVER_ERROR
            ], 500);
        }
    }

}
