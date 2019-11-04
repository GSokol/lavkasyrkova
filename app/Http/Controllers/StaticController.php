<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Category;
use App\AddCategory;
use App\Product;
use App\Tasting;
use App\UserToTasting;
use App\Shop;
use Settings;

class StaticController extends Controller
{
    use HelperTrait;
    
    protected $data = [];

    public function index()
    {
        $this->data['shops'] = Shop::all();
        $this->data['actions'] = Product::where('action',1)->where('active',1)->limit(5)->get();
//        $this->data['tasting_new'] = $this->getNewTasting();
//        if ($this->data['tasting_new']) {
//            $this->data['tastings'] = Tasting::where('id','!=',$this->data['tasting_new']->id)->orderBy('time','desc')->get();
//            if (!Auth::guest()) $this->data['tasting_signed'] = UserToTasting::where('tasting_id',$this->data['tasting_new']->id)->where('user_id',Auth::user()->id)->first();
//        }
        return $this->showView('home');
    }
    
    public function getCategoryProducts(Request $request)
    {
        $this->validate($request,['type' => 'required|in:category,add_category']);
        $type = $request->input('type');
        $this->validate($request,['id' => ($type == 'category' ? $this->validationCategory : $this->validationAddCategory)]);
        $head = $type == 'category' ? Category::where('id',$request->input('id'))->pluck('name')->first() : AddCategory::where('id',$request->input('id'))->pluck('name')->first();
        $this->data['products'] = Product::where($type.'_id',$request->input('id'))->where('active',1)->get();

        if (count($this->data['products']) > 1) {
            $maxLength = 0;
            foreach ($this->data['products'] as $product) {
                $length = mb_strlen($product->description, 'UTF-8');
                if ($length > $maxLength) $maxLength = $length;
            }
            $textHeight = ceil($maxLength/47)*15+120;
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
        $this->data['seo'] = Settings::getSeoTags();
        $this->data['categories'] = Category::all();
        $addCategories = AddCategory::all();

        $mainMenu = [];
        if (count($this->data['actions'])) $mainMenu[] = ['href' => 'actions', 'name' => 'Предложения недели'];

        $subMenu = [];
        $subMenu = $this->getCategorySubMenu($subMenu, $this->data['categories'], 'category');
        $subMenu = $this->getCategorySubMenu($subMenu, $addCategories, 'add_category');
        $mainMenu[] = ['href' => 'cheeses', 'name' => 'Наши сыры', 'submenu' => $subMenu];
        $mainMenu[] = ['href' => 'tastings', 'name' => 'Дегустации'];
        $mainMenu[] = ['href' => 'shops', 'name' => 'Магазины'];

        if (Auth::guest()) {
            $mainMenu[] = ['href' => 'login', 'name' => 'Войти'];
            $mainMenu[] = ['href' => 'register', 'name' => 'Регистрация'];
        } elseif (Auth::user()->is_admin) {
            $mainMenu[] = ['href' => 'admin', 'name' => 'Админка'];
        } else {
            $mainMenu[] = ['href' => 'profile', 'name' => 'Профиль'];
        }

        return view($view, [
            'mainMenu' => $mainMenu,
            'data' => $this->data,
            'metas' => $this->metas
        ]);
    }

    private function getCategorySubMenu($subMenu, $categories, $type)
    {
        foreach ($categories as $category) {
            $subMenu[] = [
                'href' => 'cheeses',
                'id' => $category->id,
                'type' => $type,
                'name' => $category->name
            ];
        }
        return $subMenu;
    }
}
