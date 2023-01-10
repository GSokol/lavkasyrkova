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
        $settings = Settings::getSettingsAll(true);

        return view('dashboard::pages.seo', [
            'settings' => $settings,
        ]);
    }

    public function edit(Request $request)
    {
        $this->validate($request, [
            'title' => 'max:255',
            'meta_description' => 'max:4000',
            'meta_keywords' => 'max:4000',
            'meta_twitter_card' => 'max:255',
            'meta_twitter_size' => 'max:255',
            'meta_twitter_creator' => 'max:255',
            'meta_og_url' => 'max:255',
            'meta_og_type' => 'max:255',
            'meta_og_title' => 'max:255',
            'meta_og_description' => 'max:4000',
            'meta_og_image' => 'max:255',
            'meta_robots' => 'max:255',
            'meta_googlebot' => 'max:255',
            'meta_google_site_verification' => 'max:255',
            'address[phone1]' => 'max:255',
            'address[phone2]' => 'max:255',
            'address[email]' => 'max:255',
        ]);
        Settings::saveSeoTags($request);
        return redirect(route('dashboard.seo'));
    }
}
