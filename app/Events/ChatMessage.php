<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class ChatMessage implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $user;
    public $message;
    public $roomId;
    public $timestamp;

    public function __construct(User $user, string $message, $roomId)
    {
        $this->user = $user;
        $this->message = $message;
        $this->roomId = $roomId;
        $this->timestamp = now()->toDateTimeString();
    }

    public function broadcastOn()
    {
        return new Channel("live-room.{$this->roomId}");
    }

    public function broadcastAs()
    {
        return 'chat.message';
    }
}
