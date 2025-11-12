<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id', 'receiver_id', 'message', 'file_url', 'voice_url', 'is_forwarded','seen','is_edited','reply_to_id'
    ];



    protected $casts = [
        'is_forwarded' => 'boolean',
        'seen' => 'boolean',
    ];

    public function sender() {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver() {
        return $this->belongsTo(User::class, 'receiver_id');
    }

   public function replyTo()
{
    return $this->belongsTo(Message::class, 'reply_to_id');
}




    public function reactions()
{
    return $this->hasMany(MessageReaction::class);
}


protected static function booted()
    {
        static::deleting(function ($message) {
            // ✅ Delete file if exists
            if ($message->file_url) {
                $path = str_replace(asset('storage') . '/', '', $message->file_url);
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }

            // ✅ Delete voice file if exists
            if ($message->voice_url) {
                $path = str_replace(asset('storage') . '/', '', $message->voice_url);
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }
        });
    }


}

