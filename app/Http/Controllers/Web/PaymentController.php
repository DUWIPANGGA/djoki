<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request, Order $order)
    {
        if ($request->user()->id !== $order->client_id) {
            abort(403);
        }

        $request->validate([
            'payment_method' => 'required|string',
            'payment_proof' => 'required_if:payment_method,manual_transfer|image|max:2048',
        ]);

        $paymentData = [
            'order_id' => $order->id,
            'amount' => $order->payment_type === 'dp' ? $order->dp_amount : $order->total_price,
            'payment_type' => $order->payment_type === 'dp' ? 'dp' : 'full',
            'payment_method' => $request->payment_method,
            'status' => 'pending',
        ];

        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payment_proofs', 'public');
            $paymentData['payment_proof'] = $path;
        }

        $payment = $order->payments()->create($paymentData);

        return redirect()->route('orders.show', $order)->with('success', 'Pembayaran dicatat, menunggu konfirmasi.');
    }

    public function confirm(Payment $payment, Request $request)
    {
        if ($request->user()->role !== 'admin') {
            abort(403);
        }

        $payment->update(['status' => 'success', 'paid_at' => now()]);
        $order = $payment->order;

        if ($payment->payment_type === 'dp') {
            $order->update(['payment_status' => 'dp_paid']);
        } else {
            $order->update(['payment_status' => 'paid']);
        }

        if ($order->payment_status === 'paid' && in_array($order->status, ['pending', 'accepted'])) {
            $order->update(['status' => 'in_progress', 'start_date' => now()]);
        }

        return back()->with('success', 'Pembayaran dikonfirmasi.');
    }
}
