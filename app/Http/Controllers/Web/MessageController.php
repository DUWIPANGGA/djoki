<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Order;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Order $order)
    {
        $this->authorize('view', $order);
        $messages = $order->messages()->with('user')->latest()->paginate(50);

        return view('djoki.orders.messages', compact('order', 'messages'));
    }

    public function store(Request $request, Order $order)
    {
        $this->authorize('view', $order);
        $request->validate([
            'message' => 'required_without:attachment|string',
            'attachment' => 'nullable|file|max:20480',
        ]);

        $data = [
            'order_id' => $order->id,
            'user_id' => $request->user()->id,
            'message' => $request->message,
        ];
        if ($request->hasFile('attachment')) {
            $data['attachment_path'] = $request->file('attachment')->store("chat/{$order->id}", 'public');
        }
        Message::create($data);

        return back()->with('success', 'Pesan terkirim.');
    }
}
