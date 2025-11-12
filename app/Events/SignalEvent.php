<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SignalEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;
    public $room;

    public function __construct($room, $data)
    {
        $this->room = $room;
        $this->data = $data;
    }

    public function broadcastOn()
    {
        return new PresenceChannel('room.' . $this->room);
    }
}
