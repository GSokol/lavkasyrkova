<?php

namespace Dashboard\Http\View\Composers;

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
            ['href' => route('dashboard.orders'), 'name' => 'Заказы', 'icon' => 'icon-home'],
            ['href' => route('dashboard.seo'), 'name' => 'SEO', 'icon' => 'icon-price-tags'],
            ['href' => route('dashboard.products'), 'name' => 'Продукты', 'icon' => 'icon-pie5'],
            ['href' => route('dashboard.categoryList'), 'name' => 'Категории', 'icon' => 'icon-folder'],
            ['href' => route('dashboard.settings'), 'name' => 'Настройки', 'icon' => 'icon-gear'],
            ['href' => route('dashboard.offices'), 'name' => 'Офисы', 'icon' => 'icon-office'],
            ['href' => route('dashboard.shops'), 'name' => 'Магазины', 'icon' => 'icon-basket'],
            ['href' => route('dashboard.tastings'), 'name' => 'Дегустации', 'icon' => 'icon-trophy2'],
            ['href' => route('dashboard.users'), 'name' => 'Пользователи', 'icon' => 'icon-users']
        ];
        return $menus;
    }
}
