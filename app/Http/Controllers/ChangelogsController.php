<?php

namespace App\Http\Controllers;

use App\Models\Changelog;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ChangelogsController extends Controller
{

    public function index(Request $request) {
        $page = $request->query('page') || 1;
        $offset = $request->query('offset') || 0;

        try {
            $changelogs = Changelog::paginate(10);

            return response()->json([
                'status' => 'ok',
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

}
