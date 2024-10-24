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
        $product = Product::factory()->create();

        $response = $this->get(route('admin.products.show', $product));

        $response->assertRedirect(route('admin.login'));
    }

  
    public function test_user_cannot_access_admin_products_show()
    {
        $product = Product::factory()->create();

        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.products.show', $product));

        $response->assertRedirect(route('admin.login'));
    }

   
    public function test_adminUser_can_access_admin_products_show()
    {
        $product = Product::factory()->create();
        
        $adminUser = Admin::factory()->create();

        $response = $this->actingAs($adminUser, 'admin')->get(route('admin.products.show', $product));

        $response->assertStatus(200);
    }



    public function test_guest_cannot_access_admin_products_destroy()
    {
        $product = Product::factory()->create();

        $response = $this->get(route('admin.products.destroy', $product));

        $response->assertRedirect(route('admin.login'));
    }

  
    public function test_user_cannot_access_admin_products_destroy()
    {
        $product = Product::factory()->create();

        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.products.destroy', $product));

        $response->assertRedirect(route('admin.login'));
    }

   
    public function test_adminUser_can_access_admin_products_destroy()
    {
        $product = Product::factory()->create();
        
        $adminUser = Admin::factory()->create();

        $response = $this->actingAs($adminUser, 'admin')->get(route('admin.products.destroy', $product));

        $response->assertStatus(200);
    }
}
