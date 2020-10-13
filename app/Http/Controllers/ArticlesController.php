<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Article;
use App\Models\Thread;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{

    public function index()
    {
        try {
            $articles = Article::with('thread')
                ->with('post')
                ->paginate(10);

            return response()->json([
                'status' => 'ok',
                'payload' => $articles
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
        $threadId = $request->input('thread_id');

        try {
            $thread = Thread::where('thread_id', $threadId);

            $userId = $thread['user_id'];

            $post = Post::where('thread_id', $threadId)
                ->where('user_id', $userId)
                ->orderBy('created_at', 'asc')
                ->first();

            return response()->json([
                'status' => 'ok',
                'payload' => [
                    'thread_id' => $threadId,
                    'post_id' => $post->id
                ]
            ], 200);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 'fail',
                'message' => INTERNAL_SERVER_ERROR
            ], 500);
        }
    }

    public function delete($id)
    {
        try {
            $deleted = Article::where('thread_id', $id)
                ->delete();

            if (empty($deleted)) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Article not found'
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
