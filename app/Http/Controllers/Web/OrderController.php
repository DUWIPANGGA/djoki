<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user->role === 'admin') {
            $orders = Order::with(['client', 'provider', 'service'])->latest()->paginate(20);
        } elseif ($user->role === 'provider') {
            $orders = Order::where('provider_id', $user->id)->with(['client', 'service'])->latest()->paginate(20);
        } else {
            $orders = Order::where('client_id', $user->id)->with(['provider', 'service'])->latest()->paginate(20);
        }

        return view('djoki.orders.index', compact('orders'));
    }

    public function create()
    {
        $categories = \App\Models\ServiceCategory::all();
        $services = Service::where('is_active', true)->get();

        return view('djoki.orders.create', compact('categories', 'services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'payment_type' => 'required|in:fixed,dp,negotiable',
            'estimated_completion' => 'nullable|string',
            'private_notes' => 'nullable|string',
            'attachments.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,zip|max:20480', // Max 20MB
        ]);

        $service = Service::findOrFail($validated['service_id']);
        
        $validated['client_id'] = $request->user()->id;
        $validated['status'] = 'pending';
        $validated['payment_status'] = 'unpaid';
        $validated['revision_limit'] = 2;
        $validated['total_price'] = $service->min_price;

        DB::beginTransaction();
        try {
            $order = Order::create($validated);
            
            // Handle File Uploads
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $hash = hash_file('sha256', $file->getPathname());
                    $path = $file->store("orders/{$order->id}", 'private');
                    $order->files()->create([
                        'uploaded_by' => $request->user()->id,
                        'file_name' => $file->getClientOriginalName(),
                        'file_path' => $path,
                        'file_hash' => $hash,
                        'mime_type' => $file->getMimeType(),
                        'size' => $file->getSize(),
                        'access_token' => bin2hex(random_bytes(32)),
                        'token_expires_at' => now()->addHours(24),
                    ]);
                }
            }

            if ($validated['payment_type'] === 'fixed') {
                Payment::create([
                    'order_id' => $order->id,
                    'amount' => $order->total_price ?? 0,
                    'payment_type' => 'full',
                    'status' => 'pending',
                ]);
            }
            DB::commit();

            return redirect()->route('orders.show', $order)->with('success', 'Order berhasil dibuat. Admin akan segera meninjau pesanan Anda.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membuat order: '.$e->getMessage());
        }
    }

    public function show(Order $order)
    {
        $order->load(['client', 'provider', 'service', 'milestones', 'files', 'messages.user', 'review', 'payments', 'revisions.requester', 'trackingLogs.changer']);

        // Pisahkan file client (brief/lampiran) dan file provider (hasil kerja)
        $clientFiles   = $order->files->where('file_type', 'client');
        $providerFiles = $order->files->where('file_type', 'provider');

        $providers = [];
        if (auth()->user()->role === 'admin') {
            $providers = User::where('role', 'provider')->where('is_active', true)->get();
        }

        $paymentMethods = [];
        if (auth()->user()->role === 'client' && $order->client_id === auth()->id()) {
            $paymentMethods = \App\Models\PaymentMethod::where('is_active', true)->get();
        }

        return view('djoki.orders.show', compact('order', 'providers', 'paymentMethods', 'clientFiles', 'providerFiles'));
    }

    public function edit(Order $order)
    {
        return view('djoki.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'nullable|in:pending,negotiation,accepted,in_progress,milestone_review,completed,cancelled,disputed',
            'provider_id' => 'nullable|exists:users,id',
            'total_price' => 'nullable|integer',
            'deadline' => 'nullable|date',
            'progress' => 'nullable|integer|min:0|max:100',
        ]);

        if (isset($validated['progress'])) {
            $summary = $order->milestone_summary ?? [];
            $summary['progress'] = $validated['progress'];
            $validated['milestone_summary'] = $summary;
            unset($validated['progress']);
        }

        $order->update($validated);

        return back()->with('success', 'Pesanan berhasil diperbarui.');
    }

    public function destroy(Order $order)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dihapus.');
    }

    public function download(\App\Models\Order $order, \App\Models\OrderFile $file)
    {
        // Simple download logic
        return Storage::disk('private')->download($file->file_path, $file->file_name);
    }

    public function uploadFile(Request $request, Order $order)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png,zip,rar|max:51200', // 50MB
        ]);

        $file = $request->file('file');
        $hash = hash_file('sha256', $file->getPathname());
        $path = $file->store("orders/{$order->id}", 'private');

        // Tentukan tipe file berdasarkan role uploader
        $fileType = (auth()->user()->role === 'provider') ? 'provider' : 'client';

        $order->files()->create([
            'uploaded_by'      => auth()->id(),
            'file_type'        => $fileType,
            'file_name'        => $file->getClientOriginalName(),
            'file_path'        => $path,
            'file_hash'        => $hash,
            'mime_type'        => $file->getMimeType(),
            'size'             => $file->getSize(),
            'access_token'     => bin2hex(random_bytes(32)),
            'token_expires_at' => now()->addDays(7),
        ]);

        return back()->with('success', 'File berhasil diunggah.');
    }
}
