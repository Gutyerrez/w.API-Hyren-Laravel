<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class FeatureController extends Controller
{

    function index()
    {
        try {
            $featured = Feature::all()
                ->paginate(3);

            return response()->json([
                'status' => 'ok',
                'payload' => $featured
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 'ok',
                'message' => INTERNAL_SERVER_ERROR
            ], 500);
        }
    }

    function store(Request $request)
    {
        $title = $request->input('title');
        $subTitle = $request->input('sub_title');
        $description = $request->input('description');
        $externalURL = $request->input('external_url');
        $image = $request->input('image');

        try {
            Feature::create([
                'title' => $title,
                'sub_title' => $subTitle,
                'description' => $description,
                'external_url' => $externalURL,
                'image' => $image
            ]);

            return response()->json([
                'status' => 'ok'
            ], 200);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 'ok',
                'message' => INTERNAL_SERVER_ERROR
            ], 500);
        }
    }

    function delete(Request $request, $id)
    {
        try {
            $deleted = Feature::where('id', $id)
                ->delete();

            if ($deleted < 1) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Can\'t delete this feature, are there deleted?'
                ], 500);
            }

            return response()->json([
                'status' => 'ok',
                'message' => 'Feature deleted'
            ], 200);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 'ok',
                'message' => INTERNAL_SERVER_ERROR
            ], 500);
        }
    }

}
