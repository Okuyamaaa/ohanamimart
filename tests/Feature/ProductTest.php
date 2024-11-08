<?php

namespace Tests\Feature;

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
    public function test_guest_cannot_access_index(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->get(route('products.index'));

        $response->assertRedirect('login');
    }

    public function test_user_can_access_index(){

        $user = User::factory()->create();
        $product = Product::factory()->create([
            'user_id' => $user->id
        ]);

        

        $response = $this->actingAs($user)->get(route('products.index'));

        $response->assertStatus(200);
    }

    public function test_admin_cannot_access_index(){

        $user = User::factory()->create();
        $product = Product::factory()->create([
            'user_id' => $user->id
        ]);

        $adminUser = Admin::factory()->create();

        $response = $this->actingAs($adminUser, 'admin')->get(route('products.index'));

        $response->assertRedirect('admin/home');
    }

    public function test_guest_cannot_access_show(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->get(route('products.show', ['product' => $product->id]));

        $response->assertRedirect('login');
    }

    public function test_user_can_access_show(){

        $user = User::factory()->create();
        $product = Product::factory()->create([
            'user_id' => $user->id
        ]);

        

        $response = $this->actingAs($user)->get(route('products.show', ['product' => $product->id]));

        $response->assertStatus(200);
    }

    public function test_admin_cannot_access_show(){

        $user = User::factory()->create();
        $product = Product::factory()->create([
            'user_id' => $user->id
        ]);

        $adminUser = Admin::factory()->create();

        $response = $this->actingAs($adminUser, 'admin')->get(route('products.show', ['product' => $product->id]));

        $response->assertRedirect('admin/home');
    }

    public function test_guest_cannot_access_edit(){
        $user = User::factory()->create();

        $product = Product::factory()->create([
            'user_id' => $user->id
        ]);

        $response=$this->get(route('products.edit', ['product' => $product->id]));

        $response->assertRedirect(route('login'));

    }

    public function test_cannot_others_user_access_edit(){
        $user = User::factory()->create();
        $new_user = User::factory()->create();
        $product = Product::factory()->create([
            'user_id' => $user->id
        ]);

        if($user->id != $new_user->id){

            $response = $this->actingAs($new_user)->get(route('products.edit', ['product' => $product->id]));
            $response->assertStatus(302);
        }
    }
    public function test_can_user_access_edit(){
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'user_id' => $user->id
        ]);
        

        
            $response = $this->actingAs($user)->get(route('products.edit', ['product' => $product->id]));
            $response->assertStatus(200);
        
    }

    public function test_admin_cannot_access_edit(){
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'user_id' => $user->id
        ]);

        $adminUser = Admin::factory()->create();

        $response = $this->actingAs($adminUser, 'admin')->get(route('products.edit', ['product' => $product->id]));

        $response->assertRedirect('admin/home');

    }

    public function test_guest_cannot_update(){
        
        $user = User::factory()->create();

        $product = Product::factory()->create([
            'user_id' => $user->id
        ]);

        $new_product = [
            'name' => 'テスト1',
            'description' => 'テスト1',
            'price' => 2,
            'user_id' => $user->id
        ];
        

        $response = $this->patch(route('products.update', ['product' => $product->id]), $new_product);

        $this->assertDatabaseMissing('products', $new_product);
    }

    public function test_others_user_cannot_update(){
        $user = User::factory()->create();

        $other_user = User::factory()->create();

        $product = Product::factory()->create([
            'user_id' => $user->id
        ]);

        $new_product = [
            'name' => 'テスト1',
            'description' => 'テスト1',
            'price' => 2,
            'user_id' => $user->id
        ];
        

        
            $response = $this->actingAs($other_user)->patch(route('products.update', ['product' => $product->id]), $new_product);
            $this->assertDatabaseMissing('products', $new_product);
  
    }
        public function test_user_can_update(){
            $user = User::factory()->create();
            $product = Product::factory()->create([
                'user_id' => $user->id
            ]);
    
            $new_product = [
                'name' => 'テスト1',
                'description' => 'テスト1',
                'price' => 2,
                'user_id' => $user->id
            ];

            unset($new_product['id'], $new_product['created_at'], $new_product['updated_at']);
    
            $response = $this->actingAs($user)->patch(route('products.update', ['product' => $product->id]), $new_product);
            $this->assertDatabaseHas('products', $new_product);
         


    }

    public function test_admin_cannot_update(){
        $user = User::factory()->create();

        $adminUser = Admin::factory()->create();

        $product = Product::factory()->create([
            'user_id' => $user->id
        ]);

        $new_product = [
            'name' => 'テスト1',
            'description' => 'テスト1',
            'price' => 2,
            'user_id' => $user->id
        ];

        unset($new_product['id'], $new_product['created_at'], $new_product['updated_at']);

        $response = $this->actingAs($adminUser, 'admin')->patch(route('products.edit', ['product' => $product->id]), $new_product);

        $this->assertDatabaseMissing('products', $new_product);
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

        $response = $this->delete(route('products.destroy', ['product' => $product->id]));

        $this->assertDatabaseHas('products', $product_array);
    }

    public function test_other_user_cannot_destroy(){
        $user = User::factory()->create();

        $otherUser = User::factory()->create();

        $product = Product::factory()->create([
            'user_id' => $user->id
        ]);
        $product_array = [
            'name' => 'テスト',
            'description' => 'テスト',
            'price' => 100,
            'user_id' => $user->id
        ];
            
            $response = $this->actingAs($otherUser)->delete(route('products.destroy', ['product' => $product->id]));
            $this->assertDatabaseHas('products', $product_array);
  
    }

  
    public function test_user_can_products_destroy()
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

        $response = $this->actingAs($user)->delete(route('products.destroy', ['product' => $product->id]));

        $this->assertDatabaseMissing('products', $product_array);
    }

   
    public function test_adminUser_cannot_products_destroy()
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

        $response = $this->actingAs($adminUser, 'admin')->delete(route('products.destroy', ['product' => $product->id]));

        $this->assertDatabaseHas('products', $product_array);
    }
}