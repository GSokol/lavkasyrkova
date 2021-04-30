<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;

class SettingsController extends Controller
{
    use HelperTrait;

    private $settings;

    public function __construct()
    {
        $this->settings = simplexml_load_file(public_path(Config::get('app.settings_xml')));
    }

    // Seo
    public function getSeoTags()
    {
        $tags = ['title' => ''];
        if ($this->settings->seo->title) $tags['title'] = (string)$this->settings->seo->title;
        foreach ($this->metas as $meta => $params) {
            $tags[$meta] = (string)$this->settings->seo->$meta;
        }
        return $tags;
    }

    public function getSettings()
    {
        return $this->settings->settings;
    }

    public function getAddress()
    {
        $this->settings->address->phone1 = '7(985) 920-90-38';
        $this->settings->address->phone2 = '7(916) 617-84-53';
        return $this->settings->address;
    }

    public function saveSeoTags(Request $request)
    {
        if ($request->has('title')) $this->settings->seo->title = $request->input('title');
        foreach ($this->metas as $meta => $params) {
            $this->settings->seo->$meta = $request->input($meta);
        }
        $this->save();
    }

    public function saveSettings($fields)
    {
        foreach($fields as $field => $value) {
            $this->settings->settings->$field = $value;
        }
        $this->save();
    }

    private function save()
    {
        $this->settings->asXML(Config::get('app.settings_xml'));
    }
}
