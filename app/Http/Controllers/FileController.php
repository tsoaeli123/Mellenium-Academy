<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(String $subject)
    {
        return view('student.displayDocument', compact('subject'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(String $subject)
    {
        
        $files = Document::where('subject', $subject)
              ->orderBy('created_at', 'desc')
              ->get()
              ->map(function ($file) {
        return [
            'id' => $file->id,
            'title' => $file->title,
            'type' =>pathinfo($file->filename, PATHINFO_EXTENSION),
            'url' => asset('storage/' . $file->path),
            'created_at' => $file->created_at->diffForHumans(),

        ];
    });


    return response()->json($files);
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
