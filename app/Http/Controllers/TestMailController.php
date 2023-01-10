<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class TestMailController extends Controller
{
    /**
     * Письмо клиенту с предварительной информацией о заказе
     *
     * @param string $slug
     * @return Illuminate\Support\Facades\View
     */
    public function preorder()
    {
        $order = Order::query()
            ->with(['status', 'orderToProducts.product'])
            ->where('id', 20)->first();

        return view('emails.preorder', [
            'order' => $order,
        ]);
    }

    /**
     * Письмо при оформление нового заказа
     * после выставления статуса "Собран" в админке
     *
     * @param string $slug
     * @return Illuminate\Support\Facades\View
     */
    public function newOrder()
    {
        $order = Order::query()
            ->with(['status', 'orderToProducts.product'])
            ->where('id', 20)->first();

        return view('emails.new_order', [
            'order' => $order,
        ]);
    }
}
