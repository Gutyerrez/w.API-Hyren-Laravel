<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use App\Models\Post;
use App\Models\Thread;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Misc\Utils\FormValidator;

class ThreadsController extends Controller
{

    public static function index(Request $request, $forum_id) {
        $offset = $request->query('offset', 0);
        $page = $request->query('page', 10);

        if (empty($forum_id)) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Please inform forum id'
            ], 400);
        }

        try {
            $forum = Forum::where('id', $forum_id)->first();

            if (empty($forum)) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Can\'t find specified forum'
                ], 404);
            }

            $threads = Thread::where('forum_id', $forum_id)
                ->skip($offset)
                ->take($page)
                ->get();

            return response()->json($threads, 200);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 'fail',
                'message' => INTERNAL_SERVER_ERROR
            ], 500);
        }
    }

    public function view(Request $request, $thread_id) {
        if (empty($thread_id)) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Please inform thread id'
            ], 400);
        }

        try {
            $thread = Thread::where('id', $thread_id);

            if (empty($thread)) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Can\'t find specified thread'
                ], 404);
            }

            return response()->json($thread, 200);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 'fail',
                'message' => INTERNAL_SERVER_ERROR
            ], 500);
        }
    }

    public function store(Request $request) {
        $title = $request->input('title');
        $forum_id = $request->input('forum_id');
        $user_id = $request->input('user_id');
        $body = $request->input('body');

        if (!FormValidator::isNotEmpty(
            $title,
            $forum_id,
            $user_id,
            $body
        )) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Please inform all fields'
            ], 400);
        }

        return DB::transaction(function() use ($title, $forum_id, $user_id, $body) {
            $thread = Thread::create([
                'title' => $title,
                'forum_id' => $forum_id,
                'user_id' => $user_id
            ]);

            if (empty($thread)) {
                return response()->json([
                    'status' => 'fail',
                    'message' => INTERNAL_SERVER_ERROR
                ], 500);
            }

            $post = Post::create([
                'thread_id' => $thread['id'],
                'user_id' => $user_id,
                'body' => $body
            ]);

            if (empty($post)) {
                return response()->json([
                    'status' => 'fail',
                    'message' => INTERNAL_SERVER_ERROR
                ], 500);
            }

            return response()->json([
                $thread,
                $post
            ], 201);
        });
    }

    public function update(Request $request) {

    }

    public function delete(Request $request, $thread_id) {

    }

}
