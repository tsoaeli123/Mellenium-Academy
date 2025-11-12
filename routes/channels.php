<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

// Private chat channel
Broadcast::channel('chat.{userId}', function (User $user, $userId) {
    return (int) $user->id === (int) $userId;
});

Broadcast::channel('live-room.{roomId}', function ($user, $roomId) {
    return [
        'id' => $user->id,
        'name' => $user->name,
        'role' => $user->role,
    ];
});






