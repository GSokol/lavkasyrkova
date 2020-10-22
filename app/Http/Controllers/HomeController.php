<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Tasting;
use App\Product;

class HomeController extends Controller
{
    /**
     * Главная страница
     *
     * @return Illuminate\Support\Facades\View
     */
    public function index()
    {
        $tastings = Auth::user() ? Tasting::getUserTasting(Auth::user()) : [];

        return view('face.pages.home', [
            'tastings' => $tastings,
        ]);
    }
}
