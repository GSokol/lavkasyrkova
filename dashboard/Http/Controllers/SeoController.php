<?php

namespace Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use Settings;

class SeoController extends Controller
{
    /**
     * Dashboard seo edit page
     *
     * @return Illuminate\Support\Facades\View
     */
    public function index()
    {
        $this->breadcrumbs = ['seo' => 'SEO'];
        // $seo = Settings::getSeoTags();
        $settings = Settings::getSettingsAll(true);
        // $this->data['address'] = [];
        // foreach(Settings::getAddress()->children() as $addresChild) {
        //     $this->data['address'][$addresChild->getName()] = (string)$addresChild;
        // }

        return view('dashboard::pages.seo', [
            // 'seo' => $seo,
            'settings' => $settings,
        ]);
    }
}
