<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Admin;
use App\Models\Cart;
use App\Models\Product;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_guest_cannot_access_index(): void
    {
        $response = $this->get(route('checkout.index'));

        $response->assertRedirect('/login');
    }
    public function test_user_can_access_index(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('checkout.index'));

        $response->assertStatus(200);
    }

    public function test_admin_cannot_access_index(): void
    {
        $user = User::factory()->create();
        $admin = Admin::factory()->create();

        $response = $this->actingAs($admin, 'admin')->get(route('checkout.index'));

        $response->assertRedirect('admin/home');
    }

    public function test_guest_cannot_store(): void
    {
        $auth_user = User::factory()->create();
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'user_id' => $user->id
        ]);
        $buy_product = [
            'name' => 'テスト',
            'description' => 'テスト',
            'price' => 100,
            'user_id' => $user->id,
            'purchaser_id' => $auth_user->id
        ];
        $line_items[] = [
            'price_data' => [
                'currency' => 'jpy',
                'product_data' => [
                    'name' => 'テスト',
                ],
                'unit_amount' => 100,
            ],
            'quantity' => 1,
        ];
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $checkout_session = Session::create([
            'line_items' => $line_items,
            'mode' => 'payment',
            'success_url' => route('checkout.success'),
            'cancel_url' => route('checkout.index'),
        ]);
        $response = $this->post(route('checkout.store', ['user' => $auth_user->id]));

        $response->assertRedirect('login');
    }
    public function test_user_can_store(): void
    {
        $auth_user = User::factory()->create();
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'user_id' => $user->id
        ]);
        $buy_product = [
            'name' => 'テスト',
            'description' => 'テスト',
            'price' => 100,
            'user_id' => $user->id,
            'purchaser_id' => $auth_user->id
        ];
        $line_items[] = [
            'price_data' => [
                'currency' => 'jpy',
                'product_data' => [
                    'name' => 'テスト',
                ],
                'unit_amount' => 100,
            ],
            'quantity' => 1,
        ];
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $checkout_session = Session::create([
            'line_items' => $line_items,
            'mode' => 'payment',
            'success_url' => route('checkout.success'),
            'cancel_url' => route('checkout.index'),
        ]);

        $response = $this->actingAs($auth_user)->post(route('checkout.store', ['user' => $auth_user->id]));

        $response->assertRedirect($checkout_session->url);
    }

    public function test_admin_cannot_access_store(): void
    {
        $auth_user = User::factory()->create();
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'user_id' => $user->id
        ]);
        $buy_product = [
            'name' => 'テスト',
            'description' => 'テスト',
            'price' => 100,
            'user_id' => $user->id,
            'purchaser_id' => $auth_user->id
        ];
        
        $line_items[] = [
            'price_data' => [
                'currency' => 'jpy',
                'product_data' => [
                    'name' => 'テスト',
                ],
                'unit_amount' => 100,
            ],
            'quantity' => 1,
        ];
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $checkout_session = Session::create([
            'line_items' => $line_items,
            'mode' => 'payment',
            'success_url' => route('checkout.success'),
            'cancel_url' => route('checkout.index'),
        ]);
        $admin = Admin::factory()->create();

        $response = $this->actingAs($admin, 'admin')->post(route('checkout.store', ['user' => $auth_user->id]));

        $response->assertRedirect('admin/home');
    }

    public function test_guest_cannot_success(): void
    {
        $auth_user = User::factory()->create();
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'user_id' => $user->id
        ]);
        $buy_product = [
            'name' => 'テスト',
            'description' => 'テスト',
            'price' => 100,
            'user_id' => $user->id,
            'purchaser_id' => $auth_user->id
        ];
        $line_items[] = [
            'price_data' => [
                'currency' => 'jpy',
                'product_data' => [
                    'name' => 'テスト',
                ],
                'unit_amount' => 100,
            ],
            'quantity' => 1,
        ];
        $response = $this->patch(route('checkout.success', ['user' => $auth_user->id]), $buy_product);

        $this->assertDatabaseMissing('products', $buy_product);
    }
    public function test_user_can_success(): void
    {
        $auth_user = User::factory()->create();
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'user_id' => $user->id
        ]);
        $buy_product = [
            'name' => 'テスト',
            'description' => 'テスト',
            'price' => 100,
            'user_id' => $user->id,
            'purchaser_id' => $auth_user->id
        ];
        $line_items[] = [
            'price_data' => [
                'currency' => 'jpy',
                'product_data' => [
                    'name' => 'テスト',
                ],
                'unit_amount' => 100,
            ],
            'quantity' => 1,
        ];

        $response = $this->actingAs($auth_user)->patch(route('checkout.success', ['user' => $auth_user->id]), $buy_product);

        $this->assertDatabaseHas('products', [
            'name' => 'テスト',
            'description' => 'テスト',
            'price' => 100,
            'user_id' => $user->id,
            'purchaser_id' => $auth_user->id
        ]);
    }

    public function test_admin_cannot_access_success(): void
    {
        $auth_user = User::factory()->create();
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'user_id' => $user->id
        ]);
        $buy_product = [
            'name' => 'テスト',
            'description' => 'テスト',
            'price' => 100,
            'user_id' => $user->id,
            'purchaser_id' => $auth_user->id
        ];
        $line_items[] = [
            'price_data' => [
                'currency' => 'jpy',
                'product_data' => [
                    'name' => 'テスト',
                ],
                'unit_amount' => 100,
            ],
            'quantity' => 1,
        ];
        $admin = Admin::factory()->create();

        $response = $this->actingAs($admin, 'admin')->patch(route('checkout.success', ['user' => $auth_user->id]), $buy_product);

        $this->assertDatabaseMissing('products', $buy_product);
    }

    public function test_guest_cannot_access_purchased(): void
    {
        $response = $this->get(route('checkout.purchased'));

        $response->assertRedirect('/login');
    }
    public function test_user_can_access_purchased(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('checkout.purchased'));

        $response->assertStatus(200);
    }

    public function test_admin_cannot_access_purchased(): void
    {
        $user = User::factory()->create();
        $admin = Admin::factory()->create();

        $response = $this->actingAs($admin, 'admin')->get(route('checkout.purchased'));

        $response->assertRedirect('admin/home');
    }
}
