<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Страница товаров
     *
     * @param string $slug
     * @return Illuminate\Support\Facades\View
     */
    public function product($slug)
    {
        // current product
        $product = Product::query()
            ->with(['category'])
            ->where('slug', $slug)
            ->where('active', true)
            ->firstOrFail();

        return view('pages.product', [
            'product' => $product,
        ]);
    }
}
