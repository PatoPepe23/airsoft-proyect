<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Note;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\JsonResponse;

class NoteController extends Controller
{
    public function index(): JsonResponse
    {
        $notes = Note::all();

        return response()->json($notes, 200);
    }

    public function store(Request $request): JsonResponse
    {
        $note = Note::create($request->all());
        return response()->json([
            'success'=> true,
            'data'=> $note
        ],status: 201);
    }

    public function show($id): JsonResponse
    {
        $note = Note::find($id);
        return response()->json($note, 200);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $note = Note::find($id);
        $note->update($request->all());
        return response()->json($note, 200);
    }

    public function destroy($id): JsonResponse
    {
        if (!Note::find($id)) {
            return response()->json([
                'success'=> false,
                'message'=> 'Note not found'
            ], 404);
        }
        $note = Note::find($id);
        $note->delete();
        return response()->json([
            'success'=> true
        ], 200);
    }
}
