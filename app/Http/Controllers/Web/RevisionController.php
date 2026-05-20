<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Revision;
use Illuminate\Http\Request;

class RevisionController extends Controller
{
    /**
     * Client mengajukan revisi — hanya bisa saat order COMPLETED
     * dalam window 2 hari dan belum mencapai 5 revisi.
     */
    public function store(Request $request, Order $order)
    {
        // Hanya client pemilik order yang boleh
        if ($request->user()->id !== $order->client_id) {
            abort(403, 'Akses ditolak.');
        }

        // Cek apakah status completed
        if ($order->status !== 'completed') {
            return back()->with('error', 'Revisi hanya bisa diajukan setelah pesanan berstatus Selesai.');
        }

        // Cek window 2 hari
        $windowEnd = $order->revisionWindowEndsAt();
        if (! $windowEnd || now()->isAfter($windowEnd)) {
            return back()->with('error', 'Batas waktu pengajuan revisi (2 hari setelah selesai) telah habis.');
        }

        // Cek batas maksimal 5 revisi
        if ($order->revision_count >= 5) {
            return back()->with('error', 'Anda telah mencapai batas maksimal 5 kali revisi.');
        }

        $validated = $request->validate([
            'request_details' => 'required|string|max:2000',
        ], [
            'request_details.required' => 'Keluhan / detail revisi wajib diisi.',
            'request_details.max'      => 'Keluhan maksimal 2000 karakter.',
        ]);

        // Buat revisi
        $order->revisions()->create([
            'requested_by'    => $request->user()->id,
            'request_details' => $validated['request_details'],
            'status'          => 'pending',
        ]);

        // Tambah counter & kembalikan status ke in_progress
        $order->increment('revision_count');
        $order->update(['status' => 'in_progress']);

        // Catat di tracking log
        $order->trackingLogs()->create([
            'old_status' => 'completed',
            'new_status' => 'in_progress',
            'remarks'    => 'Klien mengajukan revisi ke-' . $order->revision_count . ': ' . \Illuminate\Support\Str::limit($validated['request_details'], 80),
            'changed_by' => $request->user()->id,
        ]);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Revisi berhasil diajukan. Provider akan segera menindaklanjuti.');
    }

    /**
     * Provider/Admin update status revisi.
     */
    public function update(Request $request, Revision $revision)
    {
        $user = $request->user();

        // Hanya provider yang ditugaskan atau admin
        if ($user->role !== 'admin' && $user->id !== $revision->order->provider_id) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate(['status' => 'required|in:in_progress,completed']);

        $revision->update(['status' => $request->status]);

        // Jika revisi selesai dikerjakan, kembalikan status order ke completed
        if ($request->status === 'completed') {
            $revision->order->update(['status' => 'completed']);
        }

        return back()->with('success', 'Status revisi berhasil diperbarui.');
    }
}
