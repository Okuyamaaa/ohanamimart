<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Admin;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_guest_cannot_access_admin_products_index()
    {
     

        $response = $this->get(route('admin.products.index'));

        $response->assertRedirect(route('admin.login'));
    }

  
    public function test_user_cannot_access_admin_products_index()
    {
       

        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.products.index'));

        $response->assertRedirect(route('admin.login'));
    }

   
    public function test_adminUser_can_access_admin_products_index()
    {

        $adminUser = Admin::factory()->create();

        $response = $this->actingAs($adminUser, 'admin')->get(route('admin.products.index'));

        $response->assertStatus(200);
    }

    public function test_guest_cannot_access_admin_products_show()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->get(route('admin.products.show', ['product' => $product->id]));

        $response->assertRedirect(route('admin.login'));
    }

  
    public function test_user_cannot_access_admin_products_show()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'user_id' => $user->id
        ]);

        

        $response = $this->actingAs($user)->get(route('admin.products.show', ['product' => $product->id]));

        $response->assertRedirect(route('admin.login'));
    }

   
    public function test_adminUser_can_access_admin_products_show()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'user_id' => $user->id
        ]);
        
        $adminUser = Admin::factory()->create();

        $response = $this->actingAs($adminUser, 'admin')->get(route('admin.products.show', ['product' => $product->id]));

        $response->assertStatus(200);
    }



    public function test_guest_cannot_access_admin_products_destroy()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->get(route('admin.products.destroy', ['product' => $product->id]));

        $response->assertRedirect(route('admin.login'));
    }

  
    public function test_user_cannot_access_admin_products_destroy()
    {


        $user = User::factory()->create();
        $product = Product::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)->get(route('admin.products.destroy', ['product' => $product->id]));

        $response->assertRedirect(route('admin.login'));
    }

   
    public function test_adminUser_can_access_admin_products_destroy()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'user_id' => $user->id
        ]);
        
        $adminUser = Admin::factory()->create();

        $response = $this->actingAs($adminUser, 'admin')->get(route('admin.products.destroy', ['product' => $product->id]));

        $response->assertStatus(200);
    }

    public function test_guest_cannot_products_destroy()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'user_id' => $user->id
        ]);
        $product_array = [
            'name' => 'テスト',
            'description' => 'テスト',
            'price' => 100,
            'user_id' => $user->id
        ];

        $response = $this->delete(route('admin.products.destroy', ['product' => $product->id]));

        $this->assertDatabaseHas('products', $product_array);
    }


  
    public function test_user_cannot_products_destroy()
    {


        $user = User::factory()->create();
        $product = Product::factory()->create([
            'user_id' => $user->id
        ]);
        $product_array = [
            'name' => 'テスト',
            'description' => 'テスト',
            'price' => 100,
            'user_id' => $user->id
        ];

        $response = $this->actingAs($user)->delete(route('admin.products.destroy', ['product' => $product->id]));

        $this->assertDatabaseHas('products', $product_array);
    }

   
    public function test_adminUser_can_products_destroy()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'user_id' => $user->id
        ]);
        $product_array = [
            'name' => 'テスト',
            'description' => 'テスト',
            'price' => 100,
            'user_id' => $user->id
        ];
        
        $adminUser = Admin::factory()->create();

        $response = $this->actingAs($adminUser, 'admin')->delete(route('admin.products.destroy', ['product' => $product->id]));

        $this->assertDatabaseMissing('products', $product_array);
    }
}
