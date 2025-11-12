<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\video;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class WatchVideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(String $subject)
    {
        return view('student.displayVideo', compact('subject'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(String $subject)
    {
        
       $videos = video::where('subject', $subject)
              ->orderBy('created_at', 'desc')
              ->get()
              ->map(function ($video) {
        return [
            'title' => $video->title,
            'thumbnail' => $video->thumbnail,
            'url' => asset('storage/' . $video->path),
            'created_at' => $video->created_at->diffForHumans(),

        ];
    });


    return response()->json($videos);


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
