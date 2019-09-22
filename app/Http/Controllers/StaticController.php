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
        $this->data['categories'] = Category::all();
        $this->data['add_categories'] = AddCategory::all();
        $this->data['product_parts'] = $this->productParts;
        $this->data['products'] = Product::where('active',1)->get();
        $this->data['tasting_new'] = $this->getNewTasting();

        if ($this->data['tasting_new']) {
            $this->data['tastings'] = Tasting::where('id','!=',$this->data['tasting_new']->id)->orderBy('time','desc')->get();
            if (!Auth::guest()) $this->data['tasting_signed'] = UserToTasting::where('tasting_id',$this->data['tasting_new']->id)->where('user_id',Auth::user()->id)->first();
        }
        return $this->showView('home');
    }
    
    public function getCategoryProducts(Request $request)
    {
        $this->validate($request,['type' => 'required|in:category,add_category']);
        $type = $request->input('type');
        $this->validate($request,['id' => ($type == 'category' ? $this->validationCategory : $this->validationAddCategory)]);
        $head = $type == 'category' ? Category::where('id',$request->input('id'))->pluck('name')->first() : AddCategory::where('id',$request->input('id'))->pluck('name')->first();
        $this->data['products'] = Product::where($type.'_id',$request->input('id'))->where('active',1)->get();
        $this->data['product_parts'] = $this->productParts;
        return response()->json(['success' => true, 'products' => view('_order_products_block', ['data' => $this->data])->render(), 'head' => $head]);
    }

    private function showView($view)
    {
        $this->data['seo'] = Settings::getSeoTags();
        $mainMenu = [];
        $mainMenu[] = ['href' => 'about', 'name' => 'О компании'];
        if (count($this->data['actions'])) $mainMenu[] = ['href' => 'actions', 'name' => 'Акции'];
        $mainMenu[] = ['href' => 'cheeses', 'name' => 'Наши сыры'];
        if ($this->data['tasting_new'] || (isset($this->data['tastings']) && count($this->data['tastings']))) $mainMenu[] = ['href' => 'tastings', 'name' => 'Дегустации'];
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
}
