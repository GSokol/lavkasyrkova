<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\View;
use Auth;
// use App\Models\AddCategory;
// use App\Models\Category;
// use App\Models\Store;
// use App\Product;
// use Settings;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests; // ,HelperTrait

    protected $breadcrumbs = [];
    // protected $data = [];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $categories = Category::all();
        // $this->data['seo'] = Settings::getSeoTags();
        // $this->data['actions'] = Product::where(function($query) {
        //     $query->where('action', 1)->orWhere('new', 1);
        // })->where('active', 1)->get();
        //
        // View::share('data', $this->data);
        // View::share('metas', $this->metas);
        // View::share('mainMenu', $this->getMainMenu($categories));

        View::share('prefix', $this->getPrefix());
        View::share('menus', $this->getMainMenu());
        View::share('breadcrumbs', $this->breadcrumbs);
    }

    public function getPrefix()
    {
        return 'admin';
        // return Auth::user()->is_admin ? 'admin' : 'profile';
    }

    public function getMainMenu()
    {
        $menus = [
            ['href' => '/', 'name' => 'На главную страницу', 'icon' => 'icon-list-unordered'],
            ['href' => 'orders', 'name' => 'Заказы', 'icon' => 'icon-home'],
            ['href' => 'seo', 'name' => 'SEO', 'icon' => 'icon-price-tags'],
            ['href' => 'products', 'name' => 'Продукты', 'icon' => 'icon-pie5'],
            ['href' => 'category', 'name' => 'Категории', 'icon' => 'icon-folder'],
            ['href' => 'settings', 'name' => 'Настройки', 'icon' => 'icon-gear'],
            ['href' => 'offices', 'name' => 'Офисы', 'icon' => 'icon-office'],
            ['href' => 'shops', 'name' => 'Магазины', 'icon' => 'icon-basket'],
            ['href' => 'tastings', 'name' => 'Дегустации', 'icon' => 'icon-trophy2'],
            ['href' => 'users', 'name' => 'Пользователи', 'icon' => 'icon-users']
        ];
        return $menus;
    }
}
