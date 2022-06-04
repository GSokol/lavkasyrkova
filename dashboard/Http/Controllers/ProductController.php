<?php

namespace Dashboard\Http\Controllers;

use Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Coderello\SharedData\Facades\SharedData;
use App\Models\AddCategory;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Страница списка продуктов
     *
     * @return Illuminate\Support\Facades\View
     */
    public function productList()
    {
        $this->breadcrumbs = ['products' => 'Продукты'];
        $categories = Category::all();
        return view('dashboard::pages.product.list', [
            'categories' => $categories,
        ]);
    }

    /**
     * Страница создания/редактирования товара
     *
     * @param string|int $id
     * @return Illuminate\Support\Facades\View
     */
    public function productItem($id)
    {
        $product = Product::with(['category'])->findOrNew($id);
        $categories = Category::all();
        $addCategories = AddCategory::all();

        SharedData::put([
            'categories' => $categories,
            'product' => $product,
            'addCategories' => $addCategories,
        ]);

        return view('dashboard::pages.product.item', [
            'product' => $product,
            'categories' => $categories,
            'addCategories' => $addCategories,
        ]);
    }

    /**
     * Поиск товаров
     *
     * @param Request $request
     * @param string $request.q [search request]
     * @param int $request.limit [deault 10]
     * @return array
     */
    public function getProducts(Request $request)
    {
        $products = Product::select(['id', 'category_id', 'name', 'image'])
            ->with(['category:id,name'])
            ->limit(10)
            ->get();

        // dump($products);

        // $data = $this->validate($request, [
        //     'id' => ['required'],
        //     'discount_value' => ['sometimes', 'nullable', 'integer', 'max:50'],
        // ]);
        // // обновление данных заказа
        // $order = Order::with(['user', 'status', 'orderToProducts.product'])->findOrFail($request->get('id'));
        // $data['status_id'] = OrderStatus::code(OrderStatus::ORDER_STATUS_PICKED)->first()->id;
        // $order->update($data);
        // $order = $order->fresh();
        // // обновление значений товаров
        // $this->massUpdateOrderProducts($request);
        // // сгенерировать событие => отправка уведомления клиенту
        // event(new OrderCreated($order));

        return $this->response([
            DATA => $products,
            MSG => 'Заказ успешно обновлен',
        ]);
    }

    /**
     * Создание/редактирование товара
     *
     * @param Request $request
     * @return array
     */
    public function postProduct(Request $request)
    {
        $payload = $this->validate($request, [
            'name' => ['required', 'unique:products,name,'.$request->get('id')],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'additionally' => ['max:255'],
            'description' => ['required', 'min:3', 'max:500'],
            'whole_price' => ['integer'],
            'whole_weight' => ['required', 'integer', 'min:1', 'max:5000'],
            'part_price' => ['integer'],
            'action_whole_price' => ['integer'],
            'action_part_price' => ['integer'],
            // 'image' => ['sometimes', 'nullable', 'image', 'min:5', 'max:5000'],
            // 'big_image' => ['sometimes', 'nullable', 'image', 'min:5', 'max:5000'],
        ]);
        return $this->response([
            DATA => [123, 45],
            MSG => 'Товар успешно изменен',
        ]);

        $fields = $this->processingFields(
            $request,
            ['new','action','active','parts'],
            ['image','big_image'],
            null,
            ['whole_price','part_price','action_whole_price','action_part_price']
        );

        if ($request->has('id')) {
            $product = Product::find($request->input('id'));

            if ($request->hasFile('image'))
                $fields = array_merge($fields, $this->processingImage($request, $product, 'image'));
            if ($request->hasFile('big_image'))
                $fields = array_merge($fields, $this->processingImage($request, $product, 'big_image'));

            $product->update($fields);

        } else {
            $fields = array_merge(
                $fields,
                $this->processingImage($request, null, 'image', Str::slug($fields['name']), 'images/products'),
                $this->processingImage($request, null, 'big_image', Str::slug($fields['name']).'_big', 'images/products')
            );

            Product::create($fields);
        }
        return redirect(route('dashboard.products'));
    }
}
