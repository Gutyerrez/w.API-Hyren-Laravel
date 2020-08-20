<?php

namespace App\Http\Controllers;

use App\Models\ShortedUrl;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Misc\Utils\FormValidator;

class ShortedUrlController extends Controller
{

    public function index(Request $request)
    {
        $offset = $request->query('offset', 0);
        $page = $request->query('page', 10);

        try {
            $shorted_urls = ShortedUrl::skip($offset)->take($page)->get();
            $count = ShortedUrl::count();

            $payload = [
                'items' => $shorted_urls,
                'count' => $count
            ];

            return response()->json([
                'status' => 'ok',
                'payload' => $payload
            ], 200);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 'fail',
                'message' => INTERNAL_SERVER_ERROR
            ], 500);
        }
    }

    public function show(Request $request, $name)
    {
        if (empty($name)) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Please inform name'
            ], 400);
        }

        try {
            $shorted_url = ShortedUrl::where('name', $name)->first();

            if (empty($shorted_url)) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Can\'t find a shorted url with this id'
                ], 500);
            }

            return response()->json([
                'status' => 'ok',
                'payload' => $shorted_url
            ], 201);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 'fail',
                'message' => INTERNAL_SERVER_ERROR
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $name = $request->input('name');
        $user_id = $request->input('user_id');
        $original_url = $request->input('original_url');

        if (!FormValidator::isNotEmpty(
            $name,
            $user_id,
            $original_url
        )) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Please fill all fields'
            ], 400);
        }

        try {
            $shorted_url = ShortedUrl::create([
                'name' => $name,
                'user_id' => $user_id,
                'original_url' => $original_url
            ]);

            return response()->json([
                'status' => 'ok',
                'payload' => $shorted_url
            ], 200);
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
        $name = $request->input('name');
        $original_url = $request->input('original_url');

        if (!FormValidator::isNotEmpty(
            $id,
            $name,
            $original_url
        )) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Please fill all fields'
            ], 400);
        }

        try {
            $updated = ShortedUrl::where('id', $id)->update([
                'name' => $name,
                'original_url' => $original_url
            ]);

            if ($updated != 1) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Please fill all fields'
                ], 500);
            }

            return response()->json([
                'status' => 'ok'
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
        if (empty($id)) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Please inform shorted url id'
            ], 400);
        }

        try {
            $updated = ShortedUrl::where('id', $id)->delete();

            if ($updated != 1) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Please fill all fields'
                ], 500);
            }

            return response()->json([
                'status' => 'ok'
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 'fail',
                'message' => INTERNAL_SERVER_ERROR
            ], 500);
        }
    }

}
