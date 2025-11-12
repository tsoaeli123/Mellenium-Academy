<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Document;
use App\Models\Enrollment;
use App\Models\Subject;
use App\Models\video;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $id = Auth::id();
      $course = Subject::all();

      $enrol = Enrollment::where('user_id', $id)->get();

      
        
       return view('student.course', compact('course','enrol'));
    
    

        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

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
    public function show(string $subject)
    {
        $document = Document::where('subject', $subject)->orderBy('created_at', 'desc')->limit(5)->get();
        $video =video::where('subject', $subject)->orderBy('created_at', 'desc')->limit(5)->get();
          
       $latestDocument = Document::where('subject', $subject)->latest()->first();
        $latestVideo = video::where('subject', $subject)->latest()->first();
        return view('student.showCourse', compact('subject','document','video','latestDocument','latestVideo'));
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
