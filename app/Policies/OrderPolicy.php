<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    public function view(User $user, Order $order)
    {
        return $user->id === $order->client_id || $user->id === $order->provider_id || $user->role === 'admin';
    }

    public function update(User $user, Order $order)
    {
        return $user->id === $order->provider_id || $user->role === 'admin';
    }
}
