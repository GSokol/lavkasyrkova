<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    use HelperTrait;

    public $settings;

    public function __construct()
    {
        $this->settings = simplexml_load_file(public_path(config('app.settings_xml')));
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

    public function getSettingsAll($force = false): array
    {
        if ($force) {
            return json_decode(json_encode($this->settings), true);
        }
        return Cache::rememberForever('settings', function() {
            return json_decode(json_encode($this->settings), true);
        });
    }

    public function getSettings()
    {
        return $this->settings->settings;
    }

    public function getAddress()
    {
        return $this->settings->address;
    }

    public function saveSeoTags(Request $request)
    {
        if ($request->has('title')) $this->settings->seo->title = $request->input('title');
        foreach ($this->metas as $meta => $params) {
            $this->settings->seo->$meta = $request->input($meta);
        }
        if ($request->has('address')) {
            foreach ($request->get('address') as $key => $value) {
                $this->settings->address->$key = $value;
            }
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
        $this->settings->asXML(public_path(config('app.settings_xml')));
    }
}
