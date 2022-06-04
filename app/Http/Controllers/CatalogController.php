<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\AddCategory;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tasting;

class CatalogController extends Controller
{
    /**
     * Страница каталога
     *
     * @return Illuminate\Support\Facades\View
     */
    public function index()
    {
        $tastings = Auth::user() ? Tasting::getUserTasting(Auth::user()) : [];

        return view('pages.catalog', [
            'tastings' => $tastings,
        ]);
    }

    /**
     * Страница категории товаров
     *
     * @param string $slug
     * @return Illuminate\Support\Facades\View
     */
    public function category($slug)
    {
        $category = Category::where('slug', '=', $slug)->first() ?: AddCategory::where('slug', '=', $slug)->first();;
        if (!$category) {
            abort(404);
        }
        $products = Product::where('category_id', $category->id)
            ->with(['addCategory'])
            ->orderBy('active', 'desc')
            ->get();
        $tastings = Auth::user() ? Tasting::getUserTasting(Auth::user()) : [];

        return view('pages.category', [
            'category' => $category,
            'products' => $products,
            'tastings' => $tastings,
        ]);
    }
}
