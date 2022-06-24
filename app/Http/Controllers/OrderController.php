<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Events\OrderCreated;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Клонирование заказа
     *
     * @param  Illuminate\Http\Request $request [description]
     * @return REST array
     */
    public function postOrderRepeat(Request $request)
    {
        $this->validate($request, [
            'id' => ['required', 'numeric', 'exists:orders,id'],
        ]);
        // текущий заказ
        $order = Order::with(['orderToProducts'])->findOrFail($request->get('id'));
        // проверка на клонирование своего заказа
        $this->authorize('duplicate', [Order::class, $order]);
        // создание нового заказа
        $newOrder = Order::create([
            'delivery' => $order->delivery,
            'status_id' => 1,
            'user_id' => $order->user_id,
            'shop_id' => $order->shop_id,
            'tasting_id' => $order->tasting_id,
        ]);
        // дублирование товаров заказа
        foreach($order->orderToProducts as $orderProduct) {
            $orderProduct->order_id = $newOrder->id;
            $newOrder->orderToProducts()->create($orderProduct->toArray());
        }
        // загрузка реляций
        $newOrder->load('status', 'orderToProducts.product');
        // загрузка атрибутов
        $newOrder->setAppends(['total_amount', 'delivery_info']);
        // отправить уведомление (пользователю/менеджеру)
        event(new OrderCreated($newOrder));

        return $this->response([
            ERR => Response::HTTP_CREATED,
            MSG => 'Заказ успешно продублирован',
            DATA => $newOrder,
        ]);
    }

    /**
     * Удаление заказа
     *
     * @param  Illuminate\Http\Request $request [description]
     * @return REST array
     */
    public function deleteOrder(Request $request)
    {
        $this->validate($request, [
            'id' => ['required', 'numeric', 'exists:orders,id'],
        ]);
        // текущий заказ
        $order = Order::findOrFail($request->get('id'));
        // проверка прав
        $this->authorize('delete', [Order::class, $order]);
        // удаление
        $order->delete();


        return $this->response([
            ERR => Response::HTTP_OK,
            MSG => 'Заказ успешно удален',
        ]);
    }
}
