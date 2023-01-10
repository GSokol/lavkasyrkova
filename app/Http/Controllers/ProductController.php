<?php

namespace App\Http\Controllers;

use Coderello\SharedData\Facades\SharedData;
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
            ->with([
                'category',
                'gallery:id,model_id,model_type,path',
                'addCategory:id,name,image',
                'related',
            ])
            ->where('slug', $slug)
            // ->where('active', true)
            ->firstOrFail();

        SharedData::put([
            'product' => $product,
        ]);

        return view('pages.product', [
            'product' => $product,
        ]);
    }
}
