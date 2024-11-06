<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Admin;
use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_guest_can_access_company(): void
    {
        $company = Company::factory()->create();

        $response = $this->get(route('company.index'));

        $response->assertStatus(200);
    }

    public function test_user_can_access_company(){

        $company = Company::factory()->create();

        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('company.index'));

        $response->assertStatus(200);
    }

    public function test_admin_cannot_access_company(){

        $adminUser = Admin::factory()->create();

        $response = $this->actingAs($adminUser, 'admin')->get(route('company.index'));

        $response->assertRedirect('admin/home');
    }
}