<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Server;
use App\Models\User;
use App\Models\UserGroupDue;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Misc\Utils\FormValidator;

class UsersGroupsDueController extends Controller
{

    public function index(Request $request, $user_id) {
        if (empty($user_id)) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Please inform user id'
            ], 400);
        }

        try {
            $user = User::where('id', $user_id)
                ->with('groups')
                ->get()
                ->map(function($user) {
                    $groups = $user['groups'];

                    foreach ($groups as $index => $group) {
                        $groups[$index] = $group['name'];
                    }

                    return [
                        'name' => $user['name'],
                        'groups' => $groups
                    ];
                });

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

    public function show(Request $request, $user_id, $server_name)
    {
        if (!FormValidator::isNotEmpty($user_id, $server_name)) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Please inform user id and server name'
            ], 400);
        }

        try {
            $server = Server::where('name', $server_name)->first();

            if (empty($server)) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Server not found'
                ], 404);
            }

            $user = User::where('id', $user_id)
                ->with('groups')
                ->get()
                ->map(function($user) use ($server_name) {
                    $groups = $user['groups'];

                    foreach ($groups as $index => $group) {
                        $group_server_name = $group['server_name'];

                        if ($server_name == $group_server_name) {
                            $groups[$index] = $group['name'];
                        } else {
                            unset($groups[$index]);
                        }
                    }

                    return [
                        'name' => $user['name'],
                        'groups' => $groups
                    ];
                });

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
            $group = Group::where('name', $group_name)->first();

            if (empty($group)) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Group not found'
                ], 404);
            }

            $user = User::where('id', $user_id)->first();

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
