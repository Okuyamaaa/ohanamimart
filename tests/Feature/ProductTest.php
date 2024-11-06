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
    public function test_guest_can_access_index(): void
    {
        $user = User::factory()->create();
        $product = [
            'name' => 'テスト',
            'description' => 'テスト',
            'price' => 1,
            'user_id' => $user->id
        ];

        $response = $this->get(route('products.index'));

        $response->assertStatus(200);
    }

    public function test_user_can_access_index(){

        $user = User::factory()->create();
        $product = [
            'name' => 'テスト',
            'description' => 'テスト',
            'price' => 1,
            'user_id' => $user->id
        ];

        

        $response = $this->actingAs($user)->get(route('products.index'));

        $response->assertStatus(200);
    }

    public function test_admin_cannot_access_index(){

        $user = User::factory()->create();
        $product = [
            'name' => 'テスト',
            'description' => 'テスト',
            'price' => 1,
            'user_id' => $user->id
        ];

        $adminUser = Admin::factory()->create();

        $response = $this->actingAs($adminUser, 'admin')->get(route('products.index'));

        $response->assertRedirect('admin/home');
    }

    public function test_guest_can_access_show(): void
    {
        $user = User::factory()->create();
        $product = [
            'name' => 'テスト',
            'description' => 'テスト',
            'price' => 1,
            'user_id' => $user->id
        ];

        $response = $this->get(route('products.show', $product));

        $response->assertStatus(200);
    }

    public function test_user_can_access_show(){

        $user = User::factory()->create();
        $product = [
            'name' => 'テスト',
            'description' => 'テスト',
            'price' => 1,
            'user_id' => $user->id
        ];

        

        $response = $this->actingAs($user)->get(route('products.show', $product));

        $response->assertStatus(200);
    }

    public function test_admin_cannot_access_show(){

        $user = User::factory()->create();
        $product = [
            'name' => 'テスト',
            'description' => 'テスト',
            'price' => 1,
            'user_id' => $user->id
        ];

        $adminUser = Admin::factory()->create();

        $response = $this->actingAs($adminUser, 'admin')->get(route('products.show', [$product->id]));

        $response->assertRedirect('admin/home');
    }

    public function test_guest_cannot_access_edit(){
        $user = User::factory()->create();

        $product = [
            'name' => 'テスト',
            'description' => 'テスト',
            'price' => 1,
            'user_id' => $user->id
        ];

        $response=$this->get(route('products.edit', $product));

        $response->assertRedirect(route('login'));

    }

    public function test_cannot_others_user_access_edit(){
        $user = User::factory()->create();
        $new_user = User::factory()->create();
        $product = [
            'name' => 'テスト',
            'description' => 'テスト',
            'price' => 1,
            'user_id' => $user->id
        ];

        if($user->id != $new_user->id){

            $response = $this->actingAs($new_user)->get(route('products.edit', $product));
            $response->assertRedirect('/user');
        }
    }
    public function test_can_user_access_edit(){
        $user = User::factory()->create();
        $product = [
            'name' => 'テスト',
            'description' => 'テスト',
            'price' => 1,
            'user_id' => $user->id
        ];
        

        
            $response = $this->actingAs($user)->get(route('products.edit', $product));
            $response->assertStatus(200);
        
    }

    public function test_admin_cannot_access_edit(){
        $user = User::factory()->create();
        $product = [
            'name' => 'テスト',
            'description' => 'テスト',
            'price' => 1,
            'user_id' => $user->id
        ];

        $adminUser = Admin::factory()->create();

        $response = $this->actingAs($adminUser, 'admin')->get(route('products.edit', $product));

        $response->assertRedirect('user');

    }

    public function test_guest_cannot_update(){
        
        $user = User::factory()->create();

        $product = [
            'name' => 'テスト',
            'description' => 'テスト',
            'price' => 1,
            'user_id' => $user->id
        ];

        $new_product = [
            'name' => 'テスト1',
            'description' => 'テスト1',
            'price' => 2,
            'user_id' => $user->id
        ];
        

        $response = $this->patch(route('products.update', $product), $new_product);

        $this->assertDatabaseMissing('products', $new_product);
    }

    public function test_others_user_cannot_update(){
        $user = User::factory()->create();

        $other_user = User::factory()->create();

        $product = [
            'name' => 'テスト',
            'description' => 'テスト',
            'price' => 1,
            'user_id' => $user->id
        ];

        $new_product = [
            'name' => 'テスト1',
            'description' => 'テスト1',
            'price' => 2,
            'user_id' => $user->id
        ];
        

        
            $response = $this->actingAs($other_user)->patch(route('products.update', $product), $new_product);
            $this->assertDatabaseMissing('products', $new_product);
  
    }
        public function test_user_can_update(){
            $user = User::factory()->create();
    
            $product = [
                'name' => 'テスト',
                'description' => 'テスト',
                'price' => 1,
                'user_id' => $user->id
            ];
    
            $new_product = [
                'name' => 'テスト1',
                'description' => 'テスト1',
                'price' => 2,
                'user_id' => $user->id
            ];

            unset($new_product['id'], $new_product['created_at'], $new_product['updated_at']);
    
            $response = $this->actingAs($user)->patch(route('products.update', $product), $new_product);
            $this->assertDatabaseHas('products', $new_product);
         


    }

    public function test_admin_cannot_update(){
        $user = User::factory()->create();

        $adminUser = Admin::factory()->create();

        $product = [
            'name' => 'テスト',
            'description' => 'テスト',
            'price' => 1,
            'user_id' => $user->id
        ];

        $new_product = [
            'name' => 'テスト1',
            'description' => 'テスト1',
            'price' => 2,
            'user_id' => $user->id
        ];

        unset($new_product['id'], $new_product['created_at'], $new_product['updated_at']);

        $response = $this->actingAs($adminUser, 'admin')->patch(route('products.edit', $product), $new_product);

        $this->assertDatabaseMissing('products', $new_product);
    }
    public function test_guest_cannot_access_admin_products_destroy()
    {
        $user = User::factory()->create();
        $product = [
            'name' => 'テスト',
            'description' => 'テスト',
            'price' => 1,
            'user_id' => $user->id
        ];

        $response = $this->delete(route('products.destroy', $product));

        $this->assertDatabaseMissing('products', $product);
    }

    public function test_others_user_cannot_destroy(){
        $user = User::factory()->create();

        $other_user = User::factory()->create();

        $product = [
            'name' => 'テスト',
            'description' => 'テスト',
            'price' => 1,
            'user_id' => $user->id
        ];

        

        
            $response = $this->actingAs($other_user)->delete(route('products.destroy', $product));
            $this->assertDatabaseHas('products', $product);
  
    }

  
    public function test_user_cannot_access_admin_products_destroy()
    {


        $user = User::factory()->create();
        $product = [
            'name' => 'テスト',
            'description' => 'テスト',
            'price' => 1,
            'user_id' => $user->id
        ];

        $response = $this->actingAs($user)->delete(route('products.destroy', $product));

        $this->assertDatabaseMissing('products', $product);
    }

   
    public function test_adminUser_can_access_admin_products_destroy()
    {
        $user = User::factory()->create();
        $product = [
            'name' => 'テスト',
            'description' => 'テスト',
            'price' => 1,
            'user_id' => $user->id
        ];
        
        $adminUser = Admin::factory()->create();

        $response = $this->actingAs($adminUser, 'admin')->delete(route('products.destroy', $product));

        $this->assertDatabaseMissing('products', $product);
    }
}