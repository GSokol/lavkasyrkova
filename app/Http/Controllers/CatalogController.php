<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AddCategory;
use App\Models\Category;

class CatalogController extends Controller
{
    /**
     * Страница каталога
     *
     * @return Illuminate\Support\Facades\View
     */
    public function index() {
        return view('face.pages.catalog');
    }

    /**
     * Страница категории товаров
     *
     * @param string $slug
     * @return Illuminate\Support\Facades\View
     */
    public function category($slug) {
        $category = Category::where('slug', '=', $slug)->first() ?: AddCategory::where('slug', '=', $slug)->first();;
        if (!$category) {
            abort(404);
        }
        $this->data['products'] = $category->products;

        return view('face.pages.category', [
            'category' => $category,
            'data' => $this->data,
        ]);
    }
}
