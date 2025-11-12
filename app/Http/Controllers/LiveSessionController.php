<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LiveSessionController extends Controller
{
    public function index($roomId)
    {
        return view('live.live', compact('roomId'));
    }
}
