<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Article;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{

    public function index()
    {
        try {
            $articles = Article::with('post')
                ->paginate(1);

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
            $post = Post::where('thread_id', $threadId)
                ->where('user_id', $userId)
                ->orderBy('created_at', 'desc')
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

    public function delete(Request $request, $id)
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
