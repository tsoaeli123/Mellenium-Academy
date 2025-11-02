<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    // Show messages between teacher and student
    public function getMessages($teacherId, $studentId)
    {
        $messages = Message::where(function ($q) use ($teacherId, $studentId) {
            $q->where('sender_id', $teacherId)->where('receiver_id', $studentId);
        })->orWhere(function ($q) use ($teacherId, $studentId) {
            $q->where('sender_id', $studentId)->where('receiver_id', $teacherId);
        })->orderBy('created_at')->get();

        return view('chat.index', compact('messages', 'teacherId', 'studentId'));
    }

    // Send a message
    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required',
            'message' => 'required|string'
        ]);

        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        return back();
    }
}

