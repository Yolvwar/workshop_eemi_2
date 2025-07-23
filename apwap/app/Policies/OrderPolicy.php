<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Order;

class OrderPolicy
{
    /**
     * Determine if the user can view the order.
     */
    public function view(User $user, Order $order): bool
    {
        return $user->id === $order->user_id;
    }

    /**
     * Determine if the user can update the order.
     */
    public function update(User $user, Order $order): bool
    {
        return $user->id === $order->user_id;
    }

    /**
     * Determine if the user can cancel the order.
     */
    public function cancel(User $user, Order $order): bool
    {
        return $user->id === $order->user_id && $order->canBeCancelled();
    }
}
