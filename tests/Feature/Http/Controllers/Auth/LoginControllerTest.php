<?php

namespace Tests\Feature\Http\Controllers\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLoginPageAuthAndRedirect()
    {
        $user = factory(User::class)->create();
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'secret',
        ]);
        $response->assertRedirect(route('face.home', ['basket' => 1]));
        $this->assertAuthenticatedAs($user);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLoginPageAdminAuthAndRedirect()
    {
        $user = factory(User::class)->create([
            'is_admin' => true,
        ]);
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'secret',
        ]);
        $this->assertAuthenticatedAs($user);

        $response = $this->actingAs($user)->get('/admin');
        $response->assertRedirect(route('admin.orderList'));
        $response->assertStatus(302);
    }
}
