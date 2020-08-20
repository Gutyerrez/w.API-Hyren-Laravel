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

    public static function index(Request $request, $forum_id)
    {
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

    public function view(Request $request, $thread_id)
    {
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

    public function store(Request $request)
    {
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
                'message' => 'Please fill all fields'
            ], 400);
        }

        return DB::transaction(function () use ($title, $forum_id, $user_id, $body) {
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

            $payload = $thread['posts'] = [ $post ];

            return response()->json([
                'status' => 'ok',
                'payload' => $payload
            ], 201);
        });
    }

    public function update(Request $request, $thread_id)
    {
        $title = $request->input('title');
        $body = $request->input('body');
        $promoted = $request->input('promoted');
        $sticky = $request->input('sticky');
        $closed = $request->input('closed');
        $views = $request->input('views');
        $answers = $request->input('answers');
        $last_reply_at = $request->input('last_reply_at');

        return DB::transaction(function () use (
            $thread_id,
            $title,
            $body,
            $promoted,
            $sticky,
            $closed,
            $views,
            $answers,
            $last_reply_at
        ) {
            $updated = Thread::where('id', $thread_id)->update([
                'title' => $title,
                'promoted' => $promoted,
                'sticky' => $sticky,
                'closed' => $closed,
                'views' => $views,
                'answers' => $answers,
                'last_reply_at' => $last_reply_at
            ]);

            if ($updated != 1) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Can\'t update this thread, are there deleted?'
                ]);
            }

            $updated = Post::where('parent_id', $thread_id)->update([
                'body' => $body
            ]);

            if ($updated != 1) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Can\'t update thread body, are there deleted?'
                ]);
            }

            return response()->json([
                'status' => 'ok',
                'message' => 'Thread updated'
            ], 200);
        });
    }

    public function delete(Request $request, $thread_id)
    {
        if (empty($thread_id)) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Please inform thread id'
            ], 400);
        }

        try {
            $deleted = Thread::where('id', $thread_id)
                ->delete();

            if ($deleted != 1) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Can\'t delete this thread, are there deleted?'
                ], 404);
            }

            return response()->json([
                'status' => 'ok',
                'message' => 'Thread deleted'
            ], 200);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 'fail',
                'message' => INTERNAL_SERVER_ERROR
            ], 500);
        }
    }

}
