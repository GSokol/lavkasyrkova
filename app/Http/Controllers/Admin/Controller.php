<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests; // ,HelperTrait

    protected $breadcrumbs = [];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        View::share('prefix', $this->getPrefix());
        View::share('menus', $this->getMainMenu());
        View::share('breadcrumbs', $this->breadcrumbs);
    }

    /**
     * Returns REST response
     *
     * @param array|integer $error Error Code or array of params
     * @param array|null $params Array of additional params
     *
     * @return REST array
     */
    protected function response($params = array()) {
        $response = Arr::only($params, [ERR, CODE, MSG, DATA]);
        if (!isset($response[ERR])) {
            $response[ERR] = Response::HTTP_OK;
        }
        return $response;
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
