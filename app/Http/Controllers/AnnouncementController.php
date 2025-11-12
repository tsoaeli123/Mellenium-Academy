<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\Subject;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subject = Subject::all();
        $id = Auth::id();


        $announcements = Announcement::where('user_id', $id)
            ->orderByDesc('pinned')
            ->orderByDesc('created_at')
            ->get();
          return view('teacher.announcements', compact('subject','announcements'));
   
    }

    /**
     * Show the form for creating a new resource.
     */
  

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $id = Auth::id();
         $request->validate([
            'title'   => 'required|string|max:255',
            'message' => 'required|string',
            'subject' => 'nullable|string',
            'file'    => 'nullable|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,gif|max:20480',
        ]);

        $path = null;
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('announcements/'.$id, 'public');
        }

        $announcement = Announcement::create([
            'user_id'  => Auth::id(),
            'title'    => $request->title,
            'message'  => $request->message,
            'subject'  => $request->subject,
            'file_path'=> $path,
            'pinned'   => $request->boolean('pinned'),
        ]);

        return redirect()->back()->with('success', 'Announcement created successfully');
    }

    

   

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $announcement = Announcement::findOrFail($id);

        $announcement->update($request->only(['title', 'message', 'pinned', 'subject']));

        return response()->json($announcement);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $announcement = Announcement::findOrFail($id);
        if ($announcement->file_path) {
            Storage::disk('public')->delete($announcement->file_path);
        }
        $announcement->delete();

        return redirect()->back()->with('success', 'Announcement deleted successfully!');
    }
}
