<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class TypingEvent implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $user;
    public $receiverId;

    public function __construct(User $user, $receiverId)
    {
        $this->user = $user;
        $this->receiverId = $receiverId;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('chat.' . $this->receiverId);
    }

    public function broadcastWith()
    {
        return [
            'user' => $this->user,
        ];
    }
}
