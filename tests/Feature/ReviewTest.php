<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Admin;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    

    public function test_guest_cannot_access_create(): void
    {
        
        $user = User::factory()->create();

        $response = $this->get(route('reviews.create', $user));

        $response->assertRedirect('/login');
    }

    public function test_user_can_access_create(){
        


        $user = User::factory()->create();
        $send_user = User::factory()->create();


        $response = $this->actingAs($send_user)->get(route('reviews.create', $user));

        $response->assertStatus(200);
    }

    
    public function test_admin_cannot_access_create(){
        

        $adminUser = Admin::factory()->create();
        $user = User::factory()->create();
        

        $response = $this->actingAs($adminUser, 'admin')->get(route('reviews.create', $user));

        $response->assertredirect('admin/home');
    }
    
    public function test_guest_cannot_store(): void
    {
 
        $user = User::factory()->create();
        $send_user = User::factory()->create();

        $review = Review::factory()->create([
            'send_user_id' => $send_user->id,
            'user_id' => $user->id
        ])->toArray();


        $response = $this->post(route('reviews.store', $user), $review);

        $this->assertDatabaseMissing('reviews', $review);
    }


    public function test_subscribed_user_can_store(){
        


        $user = User::factory()->create();

       
        $send_user = User::factory()->create();
        $review = 
        ['score' => 1,
        'content' => 'テスト',
        'send_user_id' => $send_user->id];

        

        $response = $this->actingAs($send_user)->post(route('reviews.store', $user), $review);

        $this->assertDatabaseHas('reviews', $review);
    }

    public function test_admin_cannot_store(){
        

        $adminUser = Admin::factory()->create();

        $user = User::factory()->create();
        $send_user = User::factory()->create();
        $review = Review::factory()->create([
            'send_user_id' => $send_user->id,
            'user_id' => $user->id
        ])->toArray();

        $response = $this->actingAs($adminUser, 'admin')->post(route('reviews.store', $user), $review);

        $this->assertDatabaseMissing('reviews', $review);
    }

    
    public function test_guest_cannot_access_edit(): void
    {
        $user = User::factory()->create();
        $send_user = User::factory()->create();
        $review = Review::factory()->create([
            'send_user_id' => $send_user->id,
            'user_id' => $user->id
        ]);


        $response = $this->get(route('reviews.edit', [$user, $review]));

        $response->assertRedirect('/login');
    }

   
   
    public function test_user_can_access_edit(){
        $user = User::factory()->create();
        $send_user = User::factory()->create();
        $review = Review::factory()->create([
            'send_user_id' => $send_user->id,
            'user_id' => $user->id
        ]);

        

        $response = $this->actingAs($send_user)->get(route('reviews.edit', [$user, $review]));

        $response->assertStatus(200);
    }

    public function test_admin_cannot_access_edit(){


        $adminUser = Admin::factory()->create();

        $user = User::factory()->create();
        $send_user = User::factory()->create();
        $review = Review::factory()->create([
            'send_user_id' => $send_user->id,
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($adminUser, 'admin')->get(route('reviews.edit', [$user, $review]));

        $response->assertredirect('admin/home');
}
public function test_guest_cannot_update(): void
{
    $user = User::factory()->create();
    $send_user = User::factory()->create();
    $old_review = Review::factory()->create([
        'send_user_id' => $send_user->id,
        'user_id' => $user->id
    ]);

    $review = 
    ['score' => 2,
    'content' => 'シンテスト',
    'send_user_id' => $send_user->id];


    $response = $this->patch(route('reviews.update', [$user, $old_review]), $review);

    $this->assertDatabaseMissing('reviews', $review);
}




public function test_other_user_cannot_update(){
   

    $otherUser = User::factory()->create();

    $user = User::factory()->create();
    $send_user = User::factory()->create();
    $old_review = Review::factory()->create([
        'send_user_id' => $send_user->id,
        'user_id' => $user->id
    ]);

    $review = 
    ['score' => 2,
    'content' => 'シンテスト',
    'send_user_id' => $send_user->id];

    

    $response = $this->actingAs($otherUser)->patch(route('reviews.update', [$user, $old_review]), $review);

    $this->assertDatabaseMissing('reviews', $review);
}
public function testsend_user_user_can_update(){
    $user = User::factory()->create();
    $send_user = User::factory()->create();
    $old_review = Review::factory()->create([
        'send_user_id' => $send_user->id,
        'user_id' => $user->id
    ]);

    $review = 
    ['score' => 2,
    'content' => 'シンテスト',
    'send_user_id' => $send_user->id];

    

    $response = $this->actingAs($send_user)->patch(route('reviews.update', [$user, $old_review]), $review);

    $this->assertDatabaseHas('reviews', $review);
}

public function test_admin_cannot_update(){
    

    $adminUser = Admin::factory()->create();

    $user = User::factory()->create();
    $send_user = User::factory()->create();
    $old_review = Review::factory()->create([
        'send_user_id' => $send_user->id,
        'user_id' => $user->id
    ]);

    $review = 
    ['score' => 2,
    'content' => 'シンテスト',
    'send_user_id' => $send_user->id];

    $response = $this->actingAs($adminUser, 'admin')->patch(route('reviews.update', [$user, $old_review], $review));

    $this->assertDatabaseMissing('reviews', $review);
}

public function test_guest_cannot_destroy(): void
{
    $user = User::factory()->create();
    $send_user = User::factory()->create();
    $review = Review::factory()->create([
        'send_user_id' => $send_user->id,
        'user_id' => $user->id
    ]);



    $response = $this->delete(route('reviews.destroy', [$user, $review]));

    $this->assertDatabaseHas('reviews', ['id' => $review->id]);
}




public function test_other_user_cannot_destroy(){
    

    $otherUser = User::factory()->create();

    $user = User::factory()->create();
    $send_user = User::factory()->create();
    $review = Review::factory()->create([
        'send_user_id' => $send_user->id,
        'user_id' => $user->id
    ]);

    

    $response = $this->actingAs($otherUser)->delete(route('reviews.destroy', [$user, $review]));

    $this->assertDatabaseHas('reviews', ['id' => $review->id]);
}
public function test_subscribed_user_can_destroy(){
    $user = User::factory()->create();
    $send_user = User::factory()->create();
    $review = Review::factory()->create([
        'send_user_id' => $send_user->id,
        'user_id' => $user->id
    ]);
  

    

    $response = $this->actingAs($send_user)->delete(route('reviews.destroy', [$user, $review]));

    $this->assertDatabaseMissing('reviews', ['id' => $review->id]);
}

public function test_admin_cannot_destroy(){
    

    $adminUser = Admin::factory()->create();

    $user = User::factory()->create();
    $send_user = User::factory()->create();
    $review = Review::factory()->create([
        'send_user_id' => $send_user->id,
        'user_id' => $user->id
    ]);

 

    $response = $this->actingAs($adminUser, 'admin')->delete(route('reviews.destroy', [$user, $review]));

    $this->assertDatabaseHas('reviews', ['id' => $review->id]);
}
}