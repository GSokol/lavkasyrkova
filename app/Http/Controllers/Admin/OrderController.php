<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
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
        // $this->breadcrumbs['orders/1'] = 'Заказы';

        $order = Order::with(['user', 'store', 'orderToProducts.product'])->findOrFail($id);
        $orderStatuses = OrderStatus::all();

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
