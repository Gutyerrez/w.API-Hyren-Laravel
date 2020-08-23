<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class PromotedThreadsController extends Controller
{

    public function index()
    {
        try {
            $promoted = Thread::where('promoted', true)
                ->paginate(1);

            return response()->json([
                'status' => 'ok',
                'payload' => $promoted
            ], 200);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 'fail',
                'message' => INTERNAL_SERVER_ERROR
            ], 500);
        }
    }

}
