<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Admin;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_guest_cannot_access(): void
    {
        $response = $this->get(route('user.index'));

        $response->assertRedirect(route('login'));
    }
    public function test_user_can_access(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('user.index'));

        $response->assertStatus(200);
    }
    
}
