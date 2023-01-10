<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;

class SidebarComposer
{
    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
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
        $view->with('menus', $this->getMainMenu());
    }

    public function getMainMenu(): array
    {
        $menus = [
            ['href' => route('face.home'), 'name' => 'На главную страницу', 'icon' => 'icon-list-unordered'],
            ['href' => route('face.profile.orders'), 'name' => 'Заказы', 'icon' => 'icon-basket'],
            ['href' => route('face.profile.user'), 'name' => 'Профиль пользователя', 'icon' => 'icon-profile'],
        ];
        return $menus;
    }
}
