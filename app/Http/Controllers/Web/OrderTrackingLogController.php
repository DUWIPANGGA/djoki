<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderTrackingLogController extends Controller
{
    public function index(Order $order, Request $request)
    {
        $this->authorize('view', $order);
        $logs = $order->trackingLogs()->with('changer')->latest()->get();

        return view('djoki.orders.tracking-logs', compact('order', 'logs'));
    }
}
