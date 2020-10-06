<?php

namespace App\Http\Controllers;

use App\Models\Featured;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class FeaturedsController extends Controller
{

    public function index()
    {
        try {
            $featureds = Feature::all()
                ->paginate(3)
                ->orderBy('created_at', 'desc');

            return response()->json([
                'status' => 'ok',
                'payload' => $featureds
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
        $title = $request->input('title');
        $subTitle = $request->input('sub_title');
        $description = $request->input('description');
        $externalURL = $request->input('external_url');
        $image = $request->input('image');

        // upload image to amazon s3 and get image url

        $imageURL = '';

        try {
            $featured = Featured::create([
                'title' => $title,
                'sub_title' => $sub_title,
                'description' => $description,
                'external_url' => $externalURL,
                'image_url' => $imageURL
            ]);

            return response()->json([
                'status' => 'ok',
                'payload' => $featured
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
            $deleted = Featured::where('id', $id)
                ->delete();

            if (empty($deleted)) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Feature not found'
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
