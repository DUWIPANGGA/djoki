<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\VerificationDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VerificationDocumentController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        if ($user->role === 'admin') {
            $docs = VerificationDocument::with('user')->latest()->paginate(20);
        } else {
            $docs = VerificationDocument::where('user_id', $user->id)->latest()->paginate(20);
        }

        return view('djoki.verification-documents.index', compact('docs'));
    }

    public function create()
    {
        return view('djoki.verification-documents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'document_type' => 'required|string',
            'file' => 'required|file|max:10240',
        ]);
        $path = $request->file('file')->store('verifications', 'private');
        VerificationDocument::create([
            'user_id' => $request->user()->id,
            'document_type' => $request->document_type,
            'file_path' => $path,
            'status' => 'pending',
        ]);

        return redirect()->route('verification-documents.index')->with('success', 'Dokumen terkirim, menunggu verifikasi.');
    }

    public function updateStatus(Request $request, VerificationDocument $document)
    {
        if ($request->user()->role !== 'admin') {
            abort(403);
        }
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_note' => 'nullable|string',
        ]);
        $document->update($request->only('status', 'admin_note'));
        if ($request->status === 'approved') {
            $document->user->update([
                'provider_verified_at' => now(),
                'verification_status' => 'verified',
            ]);
        }

        return back()->with('success', 'Status verifikasi diupdate.');
    }

    public function destroy(VerificationDocument $document)
    {
        if (auth()->user()->role !== 'admin' && auth()->id() !== $document->user_id) {
            abort(403);
        }
        Storage::disk('private')->delete($document->file_path);
        $document->delete();

        return redirect()->route('verification-documents.index')->with('success', 'Dokumen dihapus.');
    }
}
