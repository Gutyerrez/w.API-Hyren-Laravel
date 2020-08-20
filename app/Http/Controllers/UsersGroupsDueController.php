<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use App\Models\UserGroupDue;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Misc\Utils\FormValidator;

class UsersGroupsDueController extends Controller
{

    public function show(Request $request, $user_id) {
        if (empty($user_id)) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Please inform user id'
            ], 400);
        }

        try {
            $user = User::with('groups');

            if (empty($user)) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'User not found'
                ], 404);
            }

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

    public function store(Request $request)
    {
        $user_id = $request->input('user_id');
        $group_name = $request->input('group_name');

        if (!FormValidator::isNotEmpty($user_id, $group_name)) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Please fill all fields'
            ], 400);
        }

        try {
            $group = Group::where('name', $group_name);

            if (empty($group)) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Group not found'
                ], 404);
            }

            $user = User::where('id', $user_id);

            if (empty($user)) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'User not found'
                ], 404);
            }

            $userGroupDue = UserGroupDue::create([
                'user_id' => $user_id,
                'group_name' => $group_name
            ]);

            return response()->json([
                'status' => 'ok',
                'payload' => $userGroupDue
            ], 201);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 'fail',
                'message' => INTERNAL_SERVER_ERROR
            ], 500);
        }
    }

}
