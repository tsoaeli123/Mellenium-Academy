<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Events\MessageSent;
use App\Events\TypingEvent;
use App\Events\MessageReaction;
use Illuminate\Support\Str;
use DB;

class MessageTeacherController extends Controller
{
      // Fetch all messages between current user and another
public function show($id)
{
    $authId = Auth::id();

    $messages = Message::with([
        'reactions.user:id,name',               // Load sender info for this message
    ])
    ->where(function ($q) use ($authId, $id) {
        $q->where(function ($query) use ($authId, $id) {
            $query->where('sender_id', $authId)
                  ->where('receiver_id', $id);
        })
        ->orWhere(function ($query) use ($authId, $id) {
            $query->where('sender_id', $id)
                  ->where('receiver_id', $authId);
        });
    })
    ->orderBy('created_at', 'asc')
    ->get();

    return response()->json($messages);
}




public function showReply($id)
{
    $message = \App\Models\Message::with([
        'sender:id,name',
        'receiver:id,name',
        'replyTo:id,message,file_url,voice_url,sender_id',
        'replyTo.sender:id,name'
    ])->findOrFail($id);

    $userId = auth()->id();
    if ($message->sender_id !== $userId && $message->receiver_id !== $userId) {
        abort(403, 'Unauthorized');
    }

    return response()->json($message);
}


    // Send a new message
 public function store(Request $request)
{
    try {
        // ✅ Validation
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'nullable|string',
            'file' => 'nullable|file|max:5120', // 5MB
            'voice' => 'nullable|mimes:ogg,opus,mp3,wav,webm|max:5120', 
            'reply_to_id' => 'nullable|exists:messages,id',

        ]);

        $data = [
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'reply_to_id' => $request->reply_to_id,

        ];

        // ✅ File upload
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('uploads/files', 'public');
            $data['file_url'] = asset('storage/' . $filePath);
        }

        // ✅ Voice upload
        if ($request->hasFile('voice')) {
            $file = $request->file('voice');
            $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('uploads/voices', $filename, 'public');
            $data['voice_url'] = asset('storage/' . $filePath);
        }

        // ✅ Save message
        $message = Message::create($data);

        // ✅ Broadcast if needed
        broadcast(new MessageSent($message))->toOthers();

        return response()->json(['message' => $message]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json(['errors' => $e->errors()], 422);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    // Edit a message
     public function update(Request $request, $id)
    {
        $message = Message::findOrFail($id);

        // Only allow the sender to edit
        if ($message->sender_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $message->message = $request->message;
        $message->is_edited = true;
        $message->save();

        return response()->json(['success' => true, 'message' => $message]);
    }

    // ✅ DELETE message
    public function destroy($id)
{
    $message = Message::findOrFail($id);

    // ✅ Only allow the sender to delete
    if ($message->sender_id !== Auth::id()) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    // ✅ Delete attached file (if exists)
    if ($message->file_url) {
        // Convert the public URL to a relative path if needed
        $path = str_replace(asset('storage') . '/', '', $message->file_url);

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    // ✅ Delete attached voice note (if exists)
    if ($message->voice_url) {
        $path = str_replace(asset('storage') . '/', '', $message->voice_url);

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    // ✅ Finally delete the message record
    $message->delete();

    return response()->json(['success' => true]);
}

    // Forward a message to another user
    public function forward(Request $request, Message $message)
    {
        $request->validate(['receiver_id' => 'required|exists:users,id']);

        $newMsg = $message->replicate();
        $newMsg->sender_id = Auth::id();
        $newMsg->receiver_id = $request->receiver_id;
        $newMsg->is_forwarded = true;
        $newMsg->save();

        broadcast(new MessageSent($newMsg))->toOthers();

        return response()->json($newMsg);
    }

    // React to a message 
  public function reaction(Request $request, Message $message)
{
    $emoji = $request->emoji;

    // Save or update reaction
    $reaction = \App\Models\MessageReaction::updateOrCreate(
        ['message_id' => $message->id, 'user_id' => auth()->id()],
        ['emoji' => $emoji]
    );

    // Broadcast for real-time update
    broadcast(new \App\Events\MessageReaction($message->id, $emoji, auth()->user()))->toOthers();

    return response()->json(['success' => true, 'reaction' => $reaction]);
}



    // Mark messages from a user as seen
    public function markSeen(User $user)
    {
        Message::where('sender_id', $user->id)
            ->where('receiver_id', Auth::id())
            ->update(['seen' => true]);

        return response()->json(['success' => true]);
    }

    // Typing indicator
    public function typing(User $user)
    {
        broadcast(new TypingEvent(Auth::user(), $user->id))->toOthers();
        return response()->json(['success' => true]);
    }

    // Unread counts
    public function unread()
{
    $user = auth()->user();

    // Get unread messages grouped by sender
    $unread = \DB::table('messages')
        ->select('sender_id as user_id', \DB::raw('COUNT(*) as unread_count'))
        ->where('receiver_id', $user->id)
        ->where('seen', false)
        ->groupBy('sender_id')
        ->get();

    return response()->json($unread);
}

}
