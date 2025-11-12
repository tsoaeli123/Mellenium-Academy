<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\Enrollment;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class StudentAnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

         $id = Auth::id();
         $users = User::all();
         $subject = Enrollment::where('user_id', $id)->get();
         $sub = Subject::all();
         

        $announcements = Announcement::orderBy('created_at', 'desc')
            ->get();
        return view('student.announcements',compact('announcements','users','sub','subject'));
    }

    /**
     * Show the form for creating a new resource.
     */
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
