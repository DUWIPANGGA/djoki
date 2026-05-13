<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ProviderStatistic;
use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->role === 'admin') {
            return $this->adminDashboard();
        } elseif ($user->role === 'provider') {
            return $this->providerDashboard($user);
        }

        return $this->clientDashboard($user);
    }

    protected function adminDashboard()
    {
        $data = [
            'total_users' => User::count(),
            'total_providers' => User::where('role', 'provider')->count(),
            'total_orders' => Order::count(),
            'completed_orders' => Order::where('status', 'completed')->count(),
            'revenue' => Order::where('payment_status', 'paid')->sum('total_price'),
            'active_orders' => Order::whereNotIn('status', ['completed', 'cancelled'])->count(),
            'recent_orders' => Order::with(['client', 'provider'])->latest()->limit(10)->get(),
        ];

        return view('djoki.dashboard.admin', compact('data'));
    }

    protected function providerDashboard($user)
    {
        $stat = ProviderStatistic::firstOrCreate(['provider_id' => $user->id]);
        $data = [
            'active_orders' => Order::where('provider_id', $user->id)->whereIn('status', ['accepted', 'in_progress'])->count(),
            'completed_orders' => Order::where('provider_id', $user->id)->where('status', 'completed')->count(),
            'avg_rating' => $user->rating_avg,
            'total_earned' => $user->total_earnings,
            'completion_rate' => $stat->completion_rate,
            'recent_orders' => Order::where('provider_id', $user->id)->latest()->limit(10)->get(),
        ];

        return view('djoki.dashboard.provider', compact('data'));
    }

    protected function clientDashboard($user)
    {
        $data = [
            'active_orders' => Order::where('client_id', $user->id)->whereNotIn('status', ['completed', 'cancelled'])->count(),
            'completed_orders' => Order::where('client_id', $user->id)->where('status', 'completed')->count(),
            'total_spent' => Order::where('client_id', $user->id)->where('payment_status', 'paid')->sum('total_price'),
            'recent_orders' => Order::where('client_id', $user->id)->latest()->limit(10)->get(),
            'services' => Service::where('is_active', true)->get(),
        ];

        return view('djoki.dashboard.client', compact('data'));
    }
}
