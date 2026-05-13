<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $paymentMethods = PaymentMethod::latest()->paginate(10);
        return view('djoki.payment-methods.index', compact('paymentMethods'));
    }

    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        return view('djoki.payment-methods.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'account_name' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        PaymentMethod::create($validated);

        return redirect()->route('payment-methods.index')->with('success', 'Metode pembayaran berhasil ditambahkan.');
    }

    public function edit(PaymentMethod $paymentMethod)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        return view('djoki.payment-methods.edit', compact('paymentMethod'));
    }

    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'account_name' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $paymentMethod->update($validated);

        return redirect()->route('payment-methods.index')->with('success', 'Metode pembayaran berhasil diperbarui.');
    }

    public function destroy(PaymentMethod $paymentMethod)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $paymentMethod->delete();

        return redirect()->route('payment-methods.index')->with('success', 'Metode pembayaran berhasil dihapus.');
    }
}
