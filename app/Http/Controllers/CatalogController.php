<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\AddCategory;
use App\Models\Category;
use App\Models\Tasting;

class CatalogController extends Controller
{
    /**
     * Страница каталога
     *
     * @return Illuminate\Support\Facades\View
     */
    public function index() {
        $tastings = Auth::user() ? Tasting::getUserTasting(Auth::user()) : [];

        return view('face.pages.catalog', [
            'tastings' => $tastings,
        ]);
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
        $tastings = Auth::user() ? Tasting::getUserTasting(Auth::user()) : [];
        $products = $category->products;

        return view('face.pages.category', [
            'category' => $category,
            'tastings' => $tastings,
            'products' => $products,
        ]);
    }
}
