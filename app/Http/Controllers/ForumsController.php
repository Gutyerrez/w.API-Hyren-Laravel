<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Forum;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ForumsController extends Controller
{

    public function index(Request $request, $category_id)
    {
        if (empty($category_id)) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Please inform category id'
            ], 400);
        }

        try {
            $category = Category::where('id', $category_id)->first();

            if (empty($category)) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Category not found'
                ]);
            }

            $forums = Forum::where('category_id', $category_id);

            return response()->json([
                'status' => 'ok',
                'payload' => $forums
            ], 200);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 'fail',
                'message' => INTERNAL_SERVER_ERROR
            ], 500);
        }
    }

}
