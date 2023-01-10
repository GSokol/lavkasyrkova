<?php

namespace Dashboard\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('dashboard::*', 'Dashboard\Http\View\Composers\DashboardComposer');
        View::composer('dashboard::components.sidebar', 'Dashboard\Http\View\Composers\SidebarComposer');
    }
}
