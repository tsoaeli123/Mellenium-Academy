<?php
namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageSeen implements ShouldBroadcast
{
    public $fromId;
    public $toId;

    public function __construct($fromId, $toId)
    {
        $this->fromId = $fromId;
        $this->toId = $toId;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('chat.' . $this->fromId);
    }
}

