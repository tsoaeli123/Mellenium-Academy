<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\Subject;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $id = Auth::id();
        $course = Subject::all();
        $document = Document::where('user_id', $id)->orderBy('created_at', 'desc')->get();
        return view('teacher.documentUpload', compact('document','course'));
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
             'file' => 'required|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,gif|max:20480',
        ]);

        $path = $request->file('file')->store('documents/'.$id, 'public');

        $pdf = Document::create([
             'user_id' => $id,
             'subject' => $request->subject,
             'title' => $request->title,
            'filename' => $request->file('file')->getClientOriginalName(),
            'path' => $path,
            
        ]);

        return response()->json([
            'message' => 'Document uploaded successfully!',
            'pdf' => $pdf
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
           $file = Document::findOrFail($id);
         
         if($file->path && Storage::disk('public')->exists($file->path)){
            Storage::disk('public')->delete($file->path);


         }

        

         $file->delete();



         return redirect()->back()->with('success', 'File document deleted successfully.');

    }
}
