<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SaleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_guest_cannot_access_index(): void
    {
        $response = $this->get(route('sale.index'));

        $response->assertRedirect('/login');
    }
    public function test_user_can_access_index(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('sale.index'));

        $response->assertStatus(200);
    }

    public function test_admin_cannot_access_index(): void
    {
        $user = User::factory()->create();
        $admin = Admin::factory()->create();

        $response = $this->actingAs($admin, 'admin')->get(route('sale.index'));

        $response->assertRedirect('admin/home');
    }
}
