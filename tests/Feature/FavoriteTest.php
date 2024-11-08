<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Admin;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FavoriteTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_guest_cannot_access_index(): void
    {


        $response = $this->get(route('favorites.index'));

        $response->assertRedirect('/login');
    }

  

    public function test_user_can_access_index(): void
    {
        $user = User::factory()->create();


        $response = $this->actingAs($user)->get(route('favorites.index'));

        $response->assertStatus(200);
    }

    public function test_admin_cannot_access_index(): void
    {
        $adminUser = Admin::factory()->create();
        
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'user_id' => $user->id
        ]);
        

        $response = $this->actingAs($adminUser, 'admin')->get(route('favorites.index'));

        $response->assertRedirect('admin/home');
    }

    public function test_guest_cannot_store(): void
    {
        
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'user_id' => $user->id
        ]);
        $product_user =[
            'product_id' => $product->id,
            'user_id' => $user->id
        ];


        $response = $this->post(route('favorites.store', $product->id));

        $this->assertDatabaseMissing('product_user', $product_user);
    }

   
    public function test_user_can_store(): void
    {

        $other_user = User::factory()->create();
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'user_id' => $user->id
        ]);
        $product_user =[
            'product_id' => $product->id,
            'user_id' => $user->id
        ];


        

        $response = $this->actingAs($user)->post(route('favorites.store', $product->id));

        $this->assertDatabaseHas('product_user', $product_user);
    }

    public function test_admin_cannot_store(): void
    {
        $other_user = User::factory()->create();
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'user_id' => $user->id
        ]);
        $product_user =[
            'product_id' => $product->id,
            'user_id' => $user->id
        ];

        $adminUser = Admin::factory()->create();
        $response = $this->actingAs($adminUser, 'admin')->post(route('favorites.store', $product->id));

        $this->assertDatabaseMissing('product_user', $product_user);
    }

    public function test_guest_cannot_destroy(): void
    {
        $other_user = User::factory()->create();
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'user_id' => $user->id
        ]);
        $product_user =[
            'product_id' => $product->id,
            'user_id' => $user->id
        ];

        $user->favorite_products()->attach($product->id);

        $response = $this->delete(route('favorites.destroy', $product->id));

        $this->assertDatabaseHas('product_user', $product_user);
    }

 

    public function test_user_can_destroy(): void
    {

  
        $other_user = User::factory()->create();
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'user_id' => $user->id
        ]);
        $product_user =[
            'product_id' => $product->id,
            'user_id' => $user->id
        ];

        $user->favorite_products()->attach($product->id);


        

        $response = $this->actingAs($user)->delete(route('favorites.destroy', $product->id));

        $this->assertDatabaseMissing('product_user', $product_user);
    }

    public function test_admin_cannot_destroy(): void
    {
        $other_user = User::factory()->create();
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'user_id' => $user->id
        ]);
        $product_user =[
            'product_id' => $product->id,
            'user_id' => $user->id
        ];

        $user->favorite_products()->attach($product->id);

        $adminUser = Admin::factory()->create();
        $response = $this->actingAs($adminUser, 'admin')->delete(route('favorites.destroy', $product->id));

        $this->assertDatabaseHas('product_user', $product_user);
    }
    
}