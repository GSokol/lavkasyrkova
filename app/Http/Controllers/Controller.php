<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\View;
use App\Models\AddCategory;
use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use App\Nodels\Tasting;
use Settings;
use Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, HelperTrait;

    protected $data = [];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $categories = Category::getCategories();
        $this->data['seo'] = Settings::getSeoTags();
        $this->data['actions'] = Product::getActions();
        $this->data['products'] = Product::all();

        View::share('data', $this->data);
        View::share('metas', $this->metas);
        View::share('mainMenu', $this->getMainMenu($categories));
        View::share('stores', Store::getStores());
        View::share('categories', $categories);
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

    public function getMainMenu($categories)
    {
        $addCategories = AddCategory::all();
        $mainMenu = [];
        $subMenu = [];
        $subMenu = $this->getCategorySubMenu($subMenu, $categories, 'category');
        $subMenu = $this->getCategorySubMenu($subMenu, $addCategories, 'add_category');
        $mainMenu[] = ['href' => route('face.catalog'), 'name' => 'Наши сыры ▼', 'submenu' => $subMenu];
        $mainMenu[] = ['href' => '/#tastings', 'name' => 'Дегустации'];
        $mainMenu[] = ['href' => '/#shops', 'name' => 'Магазины'];
        return $mainMenu;
    }

    private function getCategorySubMenu($subMenu, $categories, $type)
    {
        foreach ($categories as $category) {
            $subMenu[] = [
                'href' => route('face.category', ['slug' => $category->slug]),
                'id' => $category->id,
                'type' => $type,
                'name' => $category->name
            ];
        }
        return $subMenu;
    }
}
