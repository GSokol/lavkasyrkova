<?php

namespace App\Http\Controllers\Admin;

use Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Coderello\SharedData\Facades\SharedData;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\ProductToOrder;
use App\Notifications\NewOrder;

class OrderController extends Controller
{
    /**
     * Страница списка заказов
     *
     * @return Illuminate\Support\Facades\View
     */
    public function list() {
        $orders = Order::with(['user', 'status', 'orderToProducts.product'])->latest()->get();

        return view('admin.pages.order.list', [
            'orders' => $orders,
        ]);
    }

    /**
     * Страница редактирования заказа
     *
     * @return Illuminate\Support\Facades\View
     */
    public function item($id)
    {
        $order = Order::with([
            'orderToProducts.product.category',
            'user',
            'store',
        ])->findOrFail($id);

        $order->orderToProducts->transform(function($orderProduct) {
            $orderProduct->setAppends(['quantity_unit', 'amount']);
            return $orderProduct;
        });

        $orderStatuses = OrderStatus::all();

        SharedData::put([
            'order' => $order,
            'orderStatuses' => $orderStatuses,
        ]);

        return view('admin.pages.order.item', [
            'order' => $order,
            'orderStatuses' => $orderStatuses,
        ]);
    }

    /**
     * Редактировать данные заказа
     *
     * @param  Request $request [description]
     * @see https://github.com/GSokol/lavkasyrkova/issues/11
     * @return [type]           [description]
     */
    public function putOrder(Request $request)
    {
        $data = $this->validate($request, [
            'id' => ['required'],
            'discount_value' => ['sometimes', 'nullable', 'integer', 'max:50'],
        ]);
        // обновление данных заказа
        $order = Order::with(['user'])->findOrFail($request->get('id'));
        $data['status_id'] = OrderStatus::code(OrderStatus::ORDER_STATUS_PICKED)->first()->id;
        $order->update($data);
        $order = $order->fresh();
        // обновление значений товаров
        $this->massUpdateOrderProducts($request);
        // отправка уведомления клиенту
        $order->user->notify(new NewOrder($order));

        return $this->response([MSG => 'Заказ успешно обновлен']);
    }

    /**
     * Обновление данных товаров в заказе (актуальный вес)
     *
     * @param  Request $request [description]
     * @return boolean
     */
    private function massUpdateOrderProducts(Request $request): bool
    {
        $products = $request->get('order_to_products');
        $values = array_reduce($products, function($carry, $orderProduct) {
            if (!is_null($orderProduct['actual_value'])) {
                array_push($carry, Arr::only($orderProduct, ['id', 'actual_value']));
            }
            return $carry;
        }, []);
        if (count($values)) {
            return (bool)Batch::update(new ProductToOrder, $values, 'id');
        }
        return false;
    }
}
