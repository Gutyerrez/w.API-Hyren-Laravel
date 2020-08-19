<?php

namespace App\Http\Controllers;

use App\Models\Changelog;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ChangelogsController extends Controller
{

    public function index(Request $request) {
        $offset = $request->query('offset', 0);
        $page = $request->query('page', 10);

        try {
            $changelogs = Changelog::skip($offset)->take($page)->get();

            return response()->json([
                'status' => 'ok',
                'offset' => $offset,
                'page' => $page,
                'payload' => $changelogs
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 'fail',
                'message' => INTERNAL_SERVER_ERROR
            ], 500);
        }
    }

    public function store(Request $request) {
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

                return response()->json($changelog);
            } else {
                $oldChanges = json_decode($changelog['changes']);

                array_push($oldChanges, $changes);

                $changelog['changes'] = json_encode($oldChanges);

                $changelog->save();

                return response()->json($changelog);
            }
        } catch (QueryException $e) {
            return response()->json([
                'status' => 'fail',
                'message' => INTERNAL_SERVER_ERROR
            ], 500);
        }
    }

    public function delete(Request $request, $id) {
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
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 'fail',
                'message' => INTERNAL_SERVER_ERROR
            ]);
        }
    }

}
