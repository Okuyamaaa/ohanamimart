<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Admin;
use App\Models\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_guest_cannot_access_index(): void
    {
        $response = $this->get(route('cart.index'));

        $response->assertRedirect('/login');
    }
    public function test_user_can_access_index(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('cart.index'));

        $response->assertStatus(200);
    }

    public function test_admin_cannot_access_index(): void
    {
        $user = User::factory()->create();
        $admin = Admin::factory()->create();

        $response = $this->actingAs($admin, 'admin')->get(route('cart.index'));

        $response->assertRedirect('admin/home');
    }

    public function test_guest_cannot_store(): void
    {
        $auth_user = User::factory()->create();
        $user = User::factory()->create();
        $product = [
            'name' => 'テスト',
            'description' => 'テスト',
            'price' => 1,
            'user_id' => $user->id
        ];
        $cart = [
        'product_id' => $product->id,
        'user_id' => $auth_user->id];
        $response = $this->post(route('cart.store'));

        $this->assertDatebaseMissing('carts', $cart);
    }
    public function test_user_can_store(): void
    {
        $auth_user = User::factory()->create();
        $user = User::factory()->create();
        $product = [
            'name' => 'テスト',
            'description' => 'テスト',
            'price' => 1,
            'user_id' => $user->id
        ];
        $cart = [
        'product_id' => $product->id,
        'user_id' => $auth_user->id];

        $response = $this->actingAs($auth_user)->post(route('cart.store'));

        $this->assertDatebaseHas('carts', $cart);
    }

    public function test_admin_cannot_access_create(): void
    {
        $auth_user = User::factory()->create();
        $user = User::factory()->create();
        $product = [
            'name' => 'テスト',
            'description' => 'テスト',
            'price' => 1,
            'user_id' => $user->id
        ];
        $cart = [
        'product_id' => $product->id,
        'user_id' => $auth_user->id];
        $admin = Admin::factory()->create();

        $response = $this->actingAs($admin, 'admin')->get(route('cart.create'));

        $this->assertDatebaseMissing('carts', $cart);
    }

    public function test_guest_cannot_destroy(): void
    {
        $auth_user = User::factory()->create();
        $user = User::factory()->create();
        $product = [
            'name' => 'テスト',
            'description' => 'テスト',
            'price' => 1,
            'user_id' => $user->id
        ];
        $cart = [
        'product_id' => $product->id,
        'user_id' => $auth_user->id];
        $response = $this->delete(route('cart.destory'));

        $this->assertDatebaseHas('carts', $cart);
    }
    public function test_user_can_destroy(): void
    {
        $auth_user = User::factory()->create();
        $user = User::factory()->create();
        $product = [
            'name' => 'テスト',
            'description' => 'テスト',
            'price' => 1,
            'user_id' => $user->id
        ];
        $cart = [
        'product_id' => $product->id,
        'user_id' => $auth_user->id];

        $response = $this->actingAs($auth_user)->post(route('cart.destroy'));

        $this->assertDatebaseMissing('carts', $cart);
    }

    public function test_admin_cannot_access_destroy(): void
    {
        $auth_user = User::factory()->create();
        $user = User::factory()->create();
        $product = [
            'name' => 'テスト',
            'description' => 'テスト',
            'price' => 1,
            'user_id' => $user->id
        ];
        $cart = [
        'product_id' => $product->id,
        'user_id' => $auth_user->id];
        $admin = Admin::factory()->create();

        $response = $this->actingAs($admin, 'admin')->get(route('cart.destroy'));

        $this->assertDatebaseHas('carts', $cart);
    }
}
