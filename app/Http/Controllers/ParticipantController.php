<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participant;

class ParticipantController extends Controller
{
    // GET participants
public function index()
{
    return Participant::all();
}

// POST participant (join)
public function store(Request $request)
{
    $participant = Participant::updateOrCreate(
        ['socket_id' => $request->socket_id],
        [
            'name' => $request->name,
            'role' => $request->role,
            'room_id' => $request->room_id,
            'status' => 'online',
        ]
    );

    return response()->json($participant);
}

// DELETE participant (leave)
public function destroy($socket_id)
{
    $deleted = Participant::where('socket_id', $socket_id)->delete();

    if ($deleted) {
        return response()->json(['success' => true, 'message' => 'Participant removed.']);
    }

    return response()->json(['success' => false, 'message' => 'Participant not found.'], 404);
}


}
