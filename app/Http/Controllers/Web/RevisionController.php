<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Revision;
use Illuminate\Http\Request;

class RevisionController extends Controller
{
    public function store(Request $request, Order $order)
    {
        if ($request->user()->id !== $order->client_id) {
            abort(403);
        }
        if ($order->revision_count >= $order->revision_limit) {
            return back()->with('error', 'Batas revisi habis.');
        }

        $validated = $request->validate([
            'request_details' => 'required|string',
            'deadline' => 'nullable|date',
        ]);

        $revision = $order->revisions()->create([
            'requested_by' => $request->user()->id,
            'request_details' => $validated['request_details'],
            'deadline' => $validated['deadline'] ?? null,
            'status' => 'pending',
        ]);

        $order->increment('revision_count');
        $order->update(['status' => 'milestone_review']);

        return redirect()->route('orders.show', $order)->with('success', 'Permintaan revisi dikirim.');
    }

    public function update(Request $request, Revision $revision)
    {
        if ($request->user()->id !== $revision->order->provider_id) {
            abort(403);
        }
        $request->validate(['status' => 'required|in:in_progress,completed']);
        $revision->update(['status' => $request->status]);
        if ($request->status === 'completed') {
            $revision->order->update(['status' => 'in_progress']);
        }

        return back()->with('success', 'Status revisi diupdate.');
    }
}
