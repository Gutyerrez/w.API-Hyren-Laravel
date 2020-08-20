<?php

namespace App\Http\Controllers;

use App\Models\Changelog;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ChangelogsController extends Controller
{

    public function index(Request $request)
    {
        try {
            $changelogs = Changelog::paginate(DEFAULT_PER_PAGE);

            return response()->json([
                'status' => 'ok',
                'payload' => $changelogs
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
        $changes = $request->input('changes');

        try {
            $changelog = Changelog::where('title', $title)
                ->whereRaw('created_at >= CURRENT_DATE')
                ->first();

            if (empty($changelog)) {
                $changelog = Changelog::create([
                    'title' => $title,
                    'changes' => json_encode($changes)
                ]);

                return response()->json([
                    'status' => 'ok',
                    'payload' => $changelog
                ], 201);
            } else {
                $oldChanges = json_decode($changelog['changes']);

                array_push($oldChanges, $changes);

                $changelog['changes'] = json_encode($oldChanges);

                $changelog->save();

                return response()->json([
                    'status' => 'ok',
                    'payload' => $changelog
                ], 200);
            }
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
            $deleted = Changelog::where('id', $id)
                ->delete();

            if (empty($deleted)) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Can\'t find a changelog with this id'
                ], 404);
            }

            return response()->json([
                'status' => 'ok',
                'message' => 'Successfully deleted changelog #' . $id
            ], 200);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 'fail',
                'message' => INTERNAL_SERVER_ERROR
            ], 500);
        }
    }
}
