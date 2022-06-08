<?php

namespace Dashboard\Http\View\Composers;

use Illuminate\View\View;

class DashboardComposer
{
    protected $breadcrumbs = [];

    /**
     * Create a new profile composer.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Sidebar menu
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('breadcrumbs', $this->breadcrumbs);
    }
}
