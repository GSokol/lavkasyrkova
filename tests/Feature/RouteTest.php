<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Category;

class RouteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Home page test
     *
     * @return void
     */
    public function testHomePage()
    {
        $response = $this->get(route('face.home'));
        $response->assertOk();
        $response->assertViewIs('face.pages.home');
    }

    /**
     * Registration page test
     *
     * @return void
     */
    public function testRegistrationPage()
    {
        $response = $this->get('/register');
        $response->assertOk();
        $response->assertViewIs('auth.register');
    }

    /**
     * Login page test
     *
     * @return void
     */
    public function testLoginPage()
    {
        $response = $this->get('/login');
        $response->assertOk();
    }

    /**
     * Catalog page test
     *
     * @return void
     */
    public function testCatalogPage()
    {
        $response = $this->get(route('face.catalog'));
        $response->assertOk();
    }

    /**
     * Category page test
     *
     * @return void
     */
    public function testCategoryPage()
    {
        // $category = Category::inRandomOrder()->first();
        $category =  factory(Category::class)->create();
        $response = $this->get(route('face.category', ['slug' => $category->slug]));
        $response->assertOk();

        $response = $this->get(route('face.category', ['slug' => 'dfgdds-fg-sdf-gs-dfg-sdg']));
        $response->assertStatus(404);
    }
}
