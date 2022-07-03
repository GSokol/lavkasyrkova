<?php

namespace Dashboard\Http\Controllers;

use File;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
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
    public function product($id)
    {
        $product = Product::query()
            ->with(['category', 'related:id,category_id,name,image', 'related.category:id,name'])
            ->findOrNew($id);
        $product->related_products = $product->related->pluck('id');
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
    public function getProductSuggest(Request $request)
    {
        $products = Product::select(['id', 'category_id', 'name', 'image'])
            ->with(['category:id,name'])
            ->applyFilter($request)
            ->limit(10)
            ->get();

        return $this->response([
            DATA => $products,
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
            'add_category_id' => ['required', 'integer', 'exists:add_categories,id'],
            'additionally' => ['sometimes', 'nullable', 'max:255'],
            'description' => ['required', 'min:3', 'max:500'],
            'short_description' => ['sometimes', 'nullable', 'string', 'max:255'],
            'gastro_combination' => ['sometimes', 'nullable', 'string'],
            'alcohol_combination' => ['sometimes', 'nullable', 'string', 'max:255'],
            'rennet_type' => ['sometimes', 'nullable', 'string', 'max:255'],
            'nutrients' => ['sometimes', 'nullable', 'string'],
            'aging' => ['sometimes', 'nullable', 'string', 'max:255'],
            'whole_price' => ['integer'],
            'whole_weight' => ['required', 'integer', 'min:1', 'max:5000'],
            'part_price' => ['integer'],
            'action_whole_price' => ['integer'],
            'action_part_price' => ['integer'],
            'parts' => ['sometimes', 'nullable', 'boolean'],
            'active' => ['sometimes', 'nullable', 'boolean'],
            'new' => ['sometimes', 'nullable', 'boolean'],
            'action' => ['sometimes', 'nullable', 'boolean'],
            'related_products' => ['sometimes', 'nullable', 'array'],
            'related_products.*' => ['integer', 'min:1'],
        ]);
        $product = Product::updateOrCreate(['id' => $request->get('id')], $payload);
        if ($request->related_products) {
            $product->related()->sync($payload['related_products']);
        }
        if ($product->wasRecentlyCreated) {
            return $this->response([
                DATA => $product->id,
                ERR => Response::HTTP_CREATED,
                MSG => 'Товар успешно создан',
            ]);
        }
        return $this->response([
            MSG => 'Товар успешно обновлен',
        ]);
    }

    /**
     * Загрузка изображения товара
     *
     * @param Request $request
     * @return array
     */
    public function postProductImageUpload(Request $request)
    {
        $this->validate($request, [
            'file' => ['required', 'file', 'image'],
            'id' => ['required', 'numeric', 'min:1'],
        ]);
        $product = Product::find($request->id);
        $extension = $request->file('file')->extension();
        $path = $request->file('file')->storeAs('images/products', $product->slug.'.'.$extension, 'shared');
        $product->update([
            'image' => $path,
        ]);

        return $this->response([
            DATA => [
                'path' => $path,
            ],
            MSG => 'Изображение успешно загружено',
        ]);
    }

    /**
     * Удаление товара
     *
     * @param Request $request
     * @return array
     */
    public function deleteProduct(Request $request)
    {
        $this->validate($request, [
            'id' => ['required', 'min:1'],
        ]);
        $product = Product::query()->findOrFail($request->get('id'));
        if ($product->image || $product->big_image) {
            if (file_exists($product->getRawOriginal('image'))) {
                File::delete($product->getRawOriginal('image'));
            }
        }
        $product->delete();
        return $this->response([MSG => 'Товар успешно удален']);
    }
}
