<?php

namespace Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use Settings;

class SettingController extends Controller
{
    /**
     * Dashboard setting edit page
     *
     * @return Illuminate\Support\Facades\View
     */
    public function index()
    {
        $this->breadcrumbs = ['settings' => 'Настройки'];
        return view('dashboard::pages.settings');
    }

    public function editSettings(Request $request)
    {
        $payload = $this->validate($request, [
            'email' => ['required', 'email'],
            'delivery_limit' => ['sometimes', 'nullable', 'integer'],
        ]);
        Settings::saveSettings($payload);
        return redirect(route('dashboard.settings'));
    }
}
