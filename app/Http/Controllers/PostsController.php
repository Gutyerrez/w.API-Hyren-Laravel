<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Misc\Utils\FormValidator;

class PostsController extends Controller
{

    public function index(Request $request, $thread_id)
    {
        if (empty($thread_id)) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Please inform thread id'
            ], 400);
        }

        try {
            $posts = Post::where('thread_id', $thread_id)
                ->paginate(DEFAULT_PER_PAGE);

            return response()->json([
                'status' => 'ok',
                'payload' => $posts
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
        $thread_id = $request->input('thread_id');
        $body = $request->input('body');

        if (!FormValidator::isNotEmpty(
            $user_id,
            $thread_id,
            $body
        )) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Please fill fields'
            ], 400);
        }

        try {
            $user = User::where('id', $user_id)
                ->first();

            if (empty($user)) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'User not found'
                ], 404);
            }

            $thread = Thread::where('id', $thread_id)->first();

            if (empty($thread)) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Thread not found'
                ]);
            }

            $payload = Post::create([
                'user_id' => $user_id,
                'thread_id' => $thread_id,
                'body' => $body
            ]);

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

    public function update(Request $request)
    {
        $id = $request->input('id');
        $body = $request->input('body');

        try {
            $updated = Post::where('id', $id)
                ->update([
                    'body' => $body
                ]);

            if ($updated != 1) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Post not found'
                ]);
            }

            return response()->json([
                'status' => 'ok',
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 'fail',
                'message' => INTERNAL_SERVER_ERROR
            ], 500);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $deleted = Post::where('id', $id)
                ->delete();

            if ($deleted != 1) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Post not found'
                ]);
            }

            return response()->json([
                'status' => 'ok',
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 'fail',
                'message' => INTERNAL_SERVER_ERROR
            ], 500);
        }
    }

}
