<?php

namespace Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
// use Coderello\SharedData\Facades\SharedData;

class HomeController extends Controller
{
    /**
     * Dashboard home page
     *
     * @return Illuminate\Support\Facades\View
     */
    public function index()
    {
        // SharedData::put([
        //     // 'settings' => $this->getSettingsGroups(),
        // ]);

        return view('dashboard::pages.home');
    }
}
