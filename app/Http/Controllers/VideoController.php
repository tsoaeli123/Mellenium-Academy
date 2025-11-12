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

    try {
        // Basic request fields
        $fileName = $request->input('file_name');
        $chunkIndex = (int) $request->input('chunk_index', 0);
        $totalChunks = (int) $request->input('total_chunks', 1);

        // Make sure required data exists
        if (!$fileName || !$request->hasFile('video')) {
            return response()->json(['error' => 'Missing file or file_name'], 400);
        }

        // Create temporary folder for chunks
        $tempDir = storage_path("app/tmp_uploads/{$fileName}");
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        // Save current chunk
        $chunk = $request->file('video');
        $chunk->move($tempDir, "chunk_{$chunkIndex}");

        // Check if all chunks have arrived
        $allUploaded = $this->allChunksUploaded($tempDir, $totalChunks);

        if ($allUploaded) {
            // Merge chunks
            $finalFilePath = $this->mergeChunks($tempDir, $fileName);

            // Store the merged video
            $storagePath = Storage::disk('public')->putFileAs(
                'videos/'.$id,
                new \Illuminate\Http\File($finalFilePath),
                $fileName
            );

            // Delete temp folder
            $this->deleteDirectory($tempDir);

            // Save metadata
            $video = Video::create([
                'user_id' => $id,
                'subject' => $request->input('subject'),
                'title' => $request->input('title'),
                'path' => $storagePath,
                'thumbnail' => 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?w=600&h=400&fit=crop',
            ]);

            return response()->json([
                'status' => 'completed',
                'message' => 'Video successfully uploaded and merged',
                'path' => $storagePath,
            ]);
        }

        // If not last chunk, respond OK so JS can continue
        return response()->json(['status' => 'chunk_uploaded']);

    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

//Helper method for chunk
private function allChunksUploaded($dir, $totalChunks)
{
    $uploadedChunks = glob($dir . '/chunk_*');
    return count($uploadedChunks) === $totalChunks;
}

private function mergeChunks($dir, $fileName)
{
    $finalPath = storage_path("app/tmp_uploads/merged_{$fileName}");
    $out = fopen($finalPath, 'ab');

    for ($i = 0; ; $i++) {
        $chunkPath = "{$dir}/chunk_{$i}";
        if (!file_exists($chunkPath)) break;
        $in = fopen($chunkPath, 'rb');
        stream_copy_to_stream($in, $out);
        fclose($in);
    }

    fclose($out);
    return $finalPath;
}

private function deleteDirectory($dir)
{
    if (!is_dir($dir)) return;
    $files = glob($dir . '/*');
    foreach ($files as $file) {
        is_dir($file) ? $this->deleteDirectory($file) : unlink($file);
    }
    rmdir($dir);
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
