<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Admin;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_guest_can_access_index(): void
    {

        $response = $this->get(route('home'));

        $response->assertStatus(200);
    }
    public function test_user_can_access_index(): void
    {
        $user = User::factory()->create();
        $product = [
            'name' => 'テスト',
            'description' => 'テスト',
            'price' => 1,
            'user_id' => $user->id
        ];

        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('home'));

        $response->assertstatus(200);
    }

    public function test_admin_cannot_access_index(): void
    {
        $user = User::factory()->create();
        $product = [
            'name' => 'テスト',
            'description' => 'テスト',
            'price' => 1,
            'user_id' => $user->id
        ];

        $adminUser = Admin::factory()->create();

        $response = $this->actingAs($adminUser, 'admin')->get(route('home'));

        $response->assertRedirect('/admin/home');
    }


}