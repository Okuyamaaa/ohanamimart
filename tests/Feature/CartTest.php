<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Admin;
use App\Models\Cart;
use App\Models\Product;
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
        $product = Product::factory()->create([
            'user_id' => $user->id
        ]);
        $cart = [
        'product_id' => $product->id,
        'user_id' => $user->id];
        $response = $this->post(route('cart.store', ['product' => $product->id]));

        $this->assertDatabaseMissing('carts', $cart);
    }
    public function test_user_can_store(): void
    {
        $auth_user = User::factory()->create();
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'user_id' => $user->id
        ]);
        $cart = [
        'product_id' => $product->id,
        'user_id' => $user->id];

        $response = $this->actingAs($user)->post(route('cart.store', ['product' => $product->id]));

        $this->assertDatabaseHas('carts', $cart);
    }

    public function test_admin_cannot_access_store(): void
    {
        $auth_user = User::factory()->create();
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'user_id' => $user->id
        ]);
        $cart = [
        'product_id' => $product->id,
        'user_id' => $user->id];
        $admin = Admin::factory()->create();

        $response = $this->actingAs($admin, 'admin')->get(route('cart.store', ['product' => $product->id]));

        $this->assertDatabaseMissing('carts', $cart);
    }

    public function test_guest_cannot_destroy(): void
    {
        $auth_user = User::factory()->create();
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'user_id' => $user->id
        ]);
        $cart = [
        'product_id' => $product->id,
        'user_id' => $auth_user->id];

        $response = $this->delete(route('cart.destroy', ['cart' => $product->id]));

        $this->assertDatabaseHas('carts', $cart);
    }
    public function test_user_can_destroy(): void
    {
        $auth_user = User::factory()->create();
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'user_id' => $user->id
        ]);
        $cart = [
        'product_id' => $product->id,
        'user_id' => $auth_user->id];

        $response = $this->actingAs($auth_user)->delete(route('cart.destroy', ['cart' => $product->id]));

        $this->assertDatabaseMissing('carts', $cart);
    }

    public function test_admin_cannot_access_destroy(): void
    {
        $auth_user = User::factory()->create();
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'user_id' => $user->id
        ]);
        $cart = [
        'product_id' => $product->id,
        'user_id' => $auth_user->id];
        $admin = Admin::factory()->create();

        $response = $this->actingAs($admin, 'admin')->delete(route('cart.destroy', ['cart' => $product->id]));

        $this->assertDatabaseHas('carts', $cart);
    }
}
