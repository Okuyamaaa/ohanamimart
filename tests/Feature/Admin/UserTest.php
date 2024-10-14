<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    public function test_guest_cannot_access_index(): void
    {
        $response = $this->get(route('admin.users.index'));

        $response->assertRedirect('admin/login');

    }

    public function test_user_cannot_access_index(){
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.users.index'));

        $response->assertRedirect('admin/login');
    }

    public function test_admin_can_access_index(){
        $admin = Admin::factory()->create();

        $response = $this->actingAs($admin, 'admin')->get(route('admin.users.index'));

        $response->assertStatus(200);

    }

    public function test_guest_cannot_access_show(): void
    {
        $user = User::factory()->create();

        $response = $this->get(route('admin.users.show', $user));

        $response->assertRedirect('admin/login');

    }

    public function test_user_cannot_access_show(){
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.users.show', $user));

        $response->assertRedirect('admin/login');
    }

    public function test_admin_can_access_show(){

        $user = User::factory()->create();

        $admin = Admin::factory()->create();

        $response = $this->actingAs($admin, 'admin')->get(route('admin.users.show', $user));

        $response->assertStatus(200);

    }
}
