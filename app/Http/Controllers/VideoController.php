<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\video;
use App\Models\Subject;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $id = Auth::id();
        $course = Subject::all();
        $videos = video::where('user_id', $id)->orderBy('created_at', 'desc')->get();
        return view('teacher.videoUpload', compact('videos','course'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $id = Auth::id();

         $request->validate([
            'subject' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'video' => 'required|mimes:mp4,avi,mov,wmv|max:102400', // 100MB limit
        ]);

        // Store the file
        $path = $request->file('video')->store('videos/'.$id, 'public');
        $thumbnail = "https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?w=600&h=400&fit=crop";

        // Save record to database
        $video = video::create([
            'user_id' => $id,
            'subject' => $request->subject,
            'title' => $request->title,
            'path' =>  $path,
            "thumbnail" => $thumbnail,
        ]);

        return response()->json([
            'message' => 'Video uploaded successfully!',
            'path' => asset($video->path),
        ]);

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
        
            $video = video::findOrFail($id);
         
         if($video->path && Storage::disk('public')->exists($video->path)){
            Storage::disk('public')->delete($video->path);


         }

        

         $video->delete();



         return redirect()->back()->with('success', 'Video lesson deleted successfully.');




    }
}
