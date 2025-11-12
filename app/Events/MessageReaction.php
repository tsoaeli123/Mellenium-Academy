<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class MessageReaction implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $messageId;
    public $emoji;
    public $user;

    public function __construct($messageId, $emoji, User $user)
    {
        $this->messageId = $messageId;
        $this->emoji = $emoji;
        $this->user = $user;
    }

   // MessageReactionEvent.php
public function broadcastOn() {
    return new PrivateChannel('chat.' . $this->message->receiver_id);
}

public function broadcastWith() {
    return [
        'messageId' => $this->message->id,
        'emoji' => $this->emoji,
        'user' => $this->user->only('id','name'),
    ];
}

}

