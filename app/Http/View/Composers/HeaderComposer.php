<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\Category;
use App\Models\AddCategory;
use App\Models\Product;

class HeaderComposer
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
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('actions', Product::getActions());
        $view->with('mainMenu', $this->getMainMenu());
    }

    private function getMainMenu()
    {
        $categories = Category::getCategories();
        $addCategories = AddCategory::all();
        $mainMenu = [];
        $subMenu = [];
        $subMenu = $this->getCategorySubMenu($subMenu, $categories, 'category');
        $subMenu = $this->getCategorySubMenu($subMenu, $addCategories, 'add_category');
        $mainMenu[] = ['href' => route('face.catalog'), 'name' => 'Наши сыры ▼', 'submenu' => $subMenu];
        $mainMenu[] = ['href' => '/category/podarochnye-korziny', 'name' => 'Дарите подарки'];
        $mainMenu[] = ['href' => '/#shops', 'name' => 'Магазины'];
        return $mainMenu;
    }

    private function getCategorySubMenu($subMenu, $categories, $type)
    {
        foreach ($categories as $category) {
            $subMenu[] = [
                'href' => route('face.category', ['slug' => $category->slug]),
                'id' => $category->id,
                'type' => $type,
                'name' => $category->name
            ];
        }
        return $subMenu;
    }
}
