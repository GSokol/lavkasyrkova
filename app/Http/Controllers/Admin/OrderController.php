<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Coderello\SharedData\Facades\SharedData;
use App\Models\Order;
use App\Models\OrderStatus;

class OrderController extends Controller
{
    public function __construct()
    {
        // $categories = Category::all();
        // $this->data['seo'] = Settings::getSeoTags();
        // $this->data['actions'] = Product::where(function($query) {
        //     $query->where('action', 1)->orWhere('new', 1);
        // })->where('active', 1)->get();
        //
        // View::share('data', $this->data);
        // View::share('metas', $this->metas);
        // View::share('mainMenu', $this->getMainMenu($categories));

        // View::share('prefix', $this->getPrefix());
        // View::share('menus', $this->getMainMenu());
        // View::share('breadcrumbs', $this->breadcrumbs);

        parent::__construct();
    }

    /**
     * Страница редактирования заказа
     *
     * @return Illuminate\Support\Facades\View
     */
    public function item(int $id)
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

    // /**
    //  * Страница категории товаров
    //  *
    //  * @param string $slug
    //  * @return Illuminate\Support\Facades\View
    //  */
    // public function category($slug) {
    //     $category = Category::where('slug', '=', $slug)->first() ?: AddCategory::where('slug', '=', $slug)->first();;
    //     if (!$category) {
    //         abort(404);
    //     }
    //     $this->data['products'] = $category->products;
    //
    //     return view('face.pages.category', [
    //         'category' => $category,
    //         'data' => $this->data,
    //     ]);
    // }
}
