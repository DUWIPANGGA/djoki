<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ProviderStatistic;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Order $order)
    {
        if ($request->user()->id !== $order->client_id) {
            abort(403);
        }
        if ($order->status !== 'completed') {
            return back()->with('error', 'Order belum selesai.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $review = Review::create([
            'order_id' => $order->id,
            'client_id' => $request->user()->id,
            'provider_id' => $order->provider_id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        // Update average rating provider
        $avg = Review::where('provider_id', $order->provider_id)->avg('rating');
        $order->provider->update(['rating_avg' => round($avg, 1)]);

        $stat = ProviderStatistic::firstOrCreate(['provider_id' => $order->provider_id]);
        $stat->avg_rating = $avg;
        $stat->save();

        return redirect()->route('orders.show', $order)->with('success', 'Review terkirim.');
    }

    public function reply(Request $request, Review $review)
    {
        if ($request->user()->id !== $review->provider_id) {
            abort(403);
        }
        $validated = $request->validate(['provider_reply' => 'required|string']);
        $review->update([
            'provider_reply' => $validated['provider_reply'],
            'replied_at' => now(),
        ]);

        return back()->with('success', 'Balasan terkirim.');
    }
}
