<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RepositoryController extends Controller
{
    // 1) Index (Departmental access)
    public function index(Request $request)
    {
        $query = Submission::latest();

        // Filter by type if needed
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Students see only their own; Teacher/Admin see all
        if (Auth::user()->role === 'student') {
            $query->where('user_id', Auth::id());
        }

        $submissions = $query->get();

        return view('repository.index', compact('submissions'));
    }

    // 2) Upload form (students can upload; teachers/admin can also upload if you want)
    public function create()
    {
        return view('repository.create');
    }

    // 3) Store submission + file upload
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|in:thesis,internship,project',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'department' => 'nullable|string|max:255',
            'batch' => 'nullable|string|max:255',
            'supervisor_name' => 'nullable|string|max:255',
            'file' => 'required|file|max:20480|mimes:pdf,doc,docx,zip',
        ]);

        $file = $request->file('file');

        // store in: storage/app/public/repository/{userId}/
        $path = $file->store('repository/' . Auth::id(), 'public');

        Submission::create([
            'user_id' => Auth::id(),
            'type' => $request->type,
            'title' => $request->title,
            'description' => $request->description,
            'department' => $request->department,
            'batch' => $request->batch,
            'supervisor_name' => $request->supervisor_name,
            'file_path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getClientMimeType(),
            'file_size' => $file->getSize(),
        ]);

        return redirect()->route('repository.index')->with('success', 'Submission uploaded successfully!');
    }

    // 4) Download (departmental access)
    public function download($id)
    {
        $submission = Submission::findOrFail($id);

        $role = Auth::user()->role;

        // Student can only download their own
        if ($role === 'student' && Auth::id() !== $submission->user_id) {
            abort(403, 'Unauthorized.');
        }

        // Teacher/Admin can download any
        if (!Storage::disk('public')->exists($submission->file_path)) {
            abort(404, 'File not found.');
        }

        return Storage::disk('public')->download($submission->file_path, $submission->original_name);
    }

    // 5) Delete (owner or admin)
    public function destroy(Submission $repository)
    {
        if (Auth::user()->role !== 'admin' && Auth::id() !== $repository->user_id) {
            abort(403, 'Unauthorized.');
        }

        if (Storage::disk('public')->exists($repository->file_path)) {
            Storage::disk('public')->delete($repository->file_path);
        }

        $repository->delete();

        return redirect()->route('repository.index')->with('success', 'Submission deleted.');
    }
}
