<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AddCategory;
use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use App\Models\Tasting;
use Settings;
use Session;

class StaticController extends Controller
{
    use HelperTrait;

    protected $data = [];

    // deprecated
    public function getCategoryProducts(Request $request)
    {
        $this->validate($request,['type' => 'required|in:category,add_category']);
        $type = $request->input('type');
        $this->validate($request,['id' => ($type == 'category' ? 'required|integer|exists:categories,id' : $this->validationAddCategory)]);
        $head = $type == 'category' ? Category::where('id',$request->input('id'))->pluck('name')->first() : AddCategory::where('id',$request->input('id'))->pluck('name')->first();
        $this->data['products'] = Product::where($type.'_id',$request->input('id'))->get();

        if (count($this->data['products']) > 1) {
            $maxLength = 0;
            foreach ($this->data['products'] as $product) {
                $length = mb_strlen($product->description, 'UTF-8');
                if ($length > $maxLength) $maxLength = $length;
            }
            $textHeight = ceil($maxLength/47)*15+150;
        } else $textHeight = null;

        return response()->json(['success' => true, 'products' => view('_products_block', [
            'data' => $this->data,
            'textBlockHeight' => $textHeight
        ])->render(), 'head' => $head]);
    }

    public function getProduct(Request $request)
    {
        $this->validate($request,['id' => 'required|integer|exists:products,id']);
        $this->data['products'] = Product::where('id',$request->input('id'))->where('active',1)->get();
        return response()->json(['success' => true, 'product' => view('_products_block', [
            'data' => $this->data,
            'textBlockHeight' => null
        ])->render()]);
    }

    private function showView($view)
    {
        return view($view, [
            'metas' => $this->metas
        ]);
    }
}
