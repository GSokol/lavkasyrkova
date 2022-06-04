<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\View;
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
        $this->data['products'] = Product::all();

        View::share('data', $this->data);
        View::share('metas', $this->metas);
        View::share('stores', Store::getStores());
        View::share('categories', $categories);
        View::share('settings', Settings::getSettingsAll());
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
}
