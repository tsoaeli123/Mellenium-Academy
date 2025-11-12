<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
      public function index()
    {
        $role = "teacher";
        $users = User::where('role', $role)->get();
        return view('chat.chat', compact('users'));
    }


  public function all() {
 $role = "teacher";
        return response()->json(
            User::where('role', $role)->get()
        );
    }

    //teachers chats
       public function chatTeacher()
    {
        $role = "student";
        $users = User::where('role', $role)->get();
        return view('chat.message', compact('users'));
    }


  public function allTeacher() {
 $role = "student";
        return response()->json(
            User::where('role', $role)->get()
        );
    }

}
