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
        // View::shared('breadcrumbs', $this->breadcrumbs);
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
}
