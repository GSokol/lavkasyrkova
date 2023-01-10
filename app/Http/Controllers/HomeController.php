<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Product;
use App\Models\Tasting;
use App\Http\Controllers\SettingsController;

class HomeController extends Controller
{
    /**
     * Главная страница
     *
     * @return Illuminate\Support\Facades\View
     */
    public function index()
    {
        // Auth::loginUsingId(4);
        $actions = Product::getActions();
        $tastings = Auth::user() ? Tasting::getUserTasting(Auth::user()) : [];

        return view('pages.home', [
            'actions' => $actions,
            'tastings' => $tastings,
        ]);
    }
}
