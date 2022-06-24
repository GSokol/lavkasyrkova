<?php

namespace App\Policies;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Order;
use App\User;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Клонирование заказа из личного кабинета
     *
     * @param App\User $user
     * @param App\Models\Order $order
     * @return bool|AuthorizationException
     */
    public function duplicate(User $user, Order $order)
    {
        // проверка что заказ принадлежит пользователю
        if ($order->user_id !== $user->id) {
            throw new AuthorizationException('Вы можете дублировать только свои заказы');
        }
        return true;
    }

    /**
     * Удаление заказа из личного кабинета
     *
     * @param App\User $user
     * @param App\Models\Order $order
     * @return bool|AuthorizationException
     */
    public function delete(User $user, Order $order)
    {
        // проверка что заказ принадлежит пользователю
        if ($order->user_id !== $user->id) {
            throw new AuthorizationException('Вы можете удалять только свои заказы');
        }
        if ($order->status_id !== 1) {
            throw new AuthorizationException('Вы можете удалять только новые заказы');
        }
        return true;
    }
}
