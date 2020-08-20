<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UsersPunishment;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class UsersPunishmentsController extends Controller
{

    public function index(Request $request)
    {
        $offset = $request->query('offset', 0);
        $page = $request->query('page', 10);

        try {
            $punishments = UsersPunishment::skip($offset)
                ->take($page)
                ->get();
            $count = UsersPunishment::count();

            $payload = [
                'items' => $punishments,
                'count' => $count
            ];

            return response()->json([
                'status' => 'ok',
                'payload' => $payload
            ]);
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

        $user = User::where('id', $user_id)->first();

        if (empty($user)) {
            return response()->json([
                'status' => 'fail',
                'message' => 'User not found'
            ], 404);
        }

        try {
            $punishments = UsersPunishment::where('user_id', $user_id);
            $count = $punishments->count();

            $payload = [
                'items' => $punishments,
                'count' => $count
            ];

            return response()->json([
                'status' => 'ok',
                'payload' => $payload
            ], 200);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 'fail',
                'message' => INTERNAL_SERVER_ERROR
            ], 500);
        }
    }

}
