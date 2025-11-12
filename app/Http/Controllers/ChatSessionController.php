<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatMessage;
use App\Events\ChatMessage as ChatMessageEvent;
use Illuminate\Support\Facades\Auth;

class ChatSessionController extends Controller
{



 /**
     * Show the room view
     */
    public function showRoom($roomId)
    {
        return view('room', [
            'roomId' => $roomId,
            'user' => Auth::user(),
        ]);
    }

    
    // 💬 Send a message
    public function send(Request $request)
{
    $validated = $request->validate([
        'roomId' => 'required|string',
        'message' => 'required|string|max:1000',
    ]);

    $chatMessage = ChatMessage::create([
        'user_id' => Auth::id(),
        'room_id' => $validated['roomId'],
        'message' => $validated['message'],
    ]);

    $timestamp = $chatMessage->created_at->format('H:i');

    broadcast(new ChatMessageEvent($chatMessage->user, $chatMessage->room_id, $chatMessage->message))->toOthers();

    return response()->json([
        'status' => 'sent',
        'timestamp' => $timestamp,
    ]);
}


    // 📜 Load message history
     public function history($roomId)
    {
        $messages = ChatMessage::where('room_id', $roomId)
            ->with('user:id,name,role')
            ->orderBy('created_at')
            ->get()
            ->map(fn($msg) => [
                'user' => [
                    'name' => $msg->user->name,
                    'role' => $msg->user->role,
                ],
                'message' => $msg->message,
                'created_at' => $msg->created_at->format('H:i')
            ]);
        return response()->json($messages);
    }
}
