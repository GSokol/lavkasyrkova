<?php

namespace Dashboard\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;
use Coderello\SharedData\Facades\SharedData;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $breadcrumbs = [];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        View::share('menus', $this->getMainMenu());
        View::share('breadcrumbs', $this->breadcrumbs);
        // передача данных на frontend
        SharedData::put([
            'csrf' => csrf_token(),
        ]);
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

    public function getMainMenu(): array
    {
        $menus = [
            ['href' => route('face.home'), 'name' => 'На главную страницу', 'icon' => 'icon-list-unordered'],
            ['href' => route('dashboard.orders'), 'name' => 'Заказы', 'icon' => 'icon-home'],
            ['href' => route('dashboard.seo'), 'name' => 'SEO', 'icon' => 'icon-price-tags'],
            ['href' => route('dashboard.products'), 'name' => 'Продукты', 'icon' => 'icon-pie5'],
            ['href' => route('dashboard.categoryList'), 'name' => 'Категории', 'icon' => 'icon-folder'],
            ['href' => route('dashboard.settings'), 'name' => 'Настройки', 'icon' => 'icon-gear'],
            ['href' => route('dashboard.offices'), 'name' => 'Офисы', 'icon' => 'icon-office'],
            ['href' => route('dashboard.shops'), 'name' => 'Магазины', 'icon' => 'icon-basket'],
            ['href' => route('dashboard.tastings'), 'name' => 'Дегустации', 'icon' => 'icon-trophy2'],
            ['href' => route('dashboard.users'), 'name' => 'Пользователи', 'icon' => 'icon-users']
        ];
        return $menus;
    }
}
