<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        // Only show orders that have a provider
        $orders = Order::whereNotNull('provider_id')
            ->with(['client', 'provider', 'service'])
            ->latest()
            ->paginate(20);
        // Pending payments from clients (must have payment proof)
        $pendingPayments = \App\Models\Payment::where('status', 'pending')
            ->whereNotNull('payment_proof')
            ->with(['order.client', 'order.service'])
            ->latest()
            ->get();

        return view('djoki.finance.index', compact('orders', 'pendingPayments'));
    }

    public function pay(Request $request, Order $order)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('provider_payment_proofs', 'public');
            
            \Illuminate\Support\Facades\DB::transaction(function () use ($order, $path) {
                $order->update([
                    'provider_payment_status' => 'paid',
                    'provider_payment_proof_path' => $path,
                ]);

                // Increment provider earnings (Net after 12% platform fee)
                $provider = $order->provider;
                $netEarnings = $order->total_price * 0.88;
                $provider->increment('total_earnings', $netEarnings);
            });

            return back()->with('success', 'Pembayaran ke provider berhasil dicatat, bukti diunggah, dan penghasilan provider diperbarui.');
        }

        return back()->with('error', 'Gagal mengunggah bukti pembayaran.');
    }

    public function providerIndex()
    {
        if (auth()->user()->role !== 'provider') {
            abort(403);
        }

        $orders = Order::where('provider_id', auth()->id())
            ->with(['client', 'service'])
            ->latest()
            ->paginate(20);

        return view('djoki.finance.provider', compact('orders'));
    }
}
