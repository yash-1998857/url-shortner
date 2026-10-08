<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use App\Models\SuperAdmin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\GeneratedUrl;

class UrlShortenerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_short_url(): void
    {
        $company = Company::create([
            'company_name' => 'Test Company',
        ]);

        $admin = User::create([
            'company_id' => $company->id,
            'name' => 'Test Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->post('/urls', [
            'long_url' => 'https://google.com',
        ]);

        $response->assertRedirect('/dashboard');

        $this->assertDatabaseHas('generated_urls', [
            'company_id' => $company->id,
            'user_id' => $admin->id,
            'long_url' => 'https://google.com',
        ]);
    }

    public function test_member_can_create_short_url(): void
    {
        $company = Company::create([
            'company_name' => 'Test Company',
        ]);

        $member = User::create([
            'company_id' => $company->id,
            'name' => 'Test Member',
            'email' => 'member@test.com',
            'password' => bcrypt('password'),
            'role' => 'member',
        ]);

        $response = $this->actingAs($member)->post('/urls', [
            'long_url' => 'https://google.com',
        ]);

        $response->assertRedirect('/dashboard');

        $this->assertDatabaseHas('generated_urls', [
            'company_id' => $company->id,
            'user_id' => $member->id,
            'long_url' => 'https://google.com',
        ]);
    }
    public function test_superadmin_cannot_create_short_url(): void
    {
        $superAdmin = SuperAdmin::create([
            'username' => 'Test SuperAdmin',
            'email' => 'superadmin@test.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->post('/urls', [
            'long_url' => 'https://google.com',
        ]);

        $response->assertRedirect('/login');

        $this->assertDatabaseMissing('generated_urls', [
            'long_url' => 'https://google.com',
        ]);
    }

    public function test_admin_can_only_see_urls_from_their_company(): void
    {
        $company1 = Company::create([
            'company_name' => 'Company One',
        ]);

        $company2 = Company::create([
            'company_name' => 'Company Two',
        ]);

        $admin = User::create([
            'company_id' => $company1->id,
            'name' => 'Test Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        GeneratedUrl::create([
            'company_id' => $company1->id,
            'user_id' => $admin->id,
            'long_url' => 'https://company-one.com',
            'short_url' => 'abc123',
        ]);

        $otherUser = User::create([
            'company_id' => $company2->id,
            'name' => 'Other User',
            'email' => 'other@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        GeneratedUrl::create([
            'company_id' => $company2->id,
            'user_id' => $otherUser->id,
            'long_url' => 'https://company-two.com',
            'short_url' => 'xyz789',
        ]);

        $response = $this->actingAs($admin)->get('/dashboard');

        $response->assertSee('https://company-one.com');
        $response->assertDontSee('https://company-two.com');
    }

    public function test_member_can_only_see_their_own_urls(): void
    {
        $company = Company::create([
            'company_name' => 'Test Company',
        ]);

        $member1 = User::create([
            'company_id' => $company->id,
            'name' => 'Member One',
            'email' => 'member1@test.com',
            'password' => bcrypt('password'),
            'role' => 'member',
        ]);

        $member2 = User::create([
            'company_id' => $company->id,
            'name' => 'Member Two',
            'email' => 'member2@test.com',
            'password' => bcrypt('password'),
            'role' => 'member',
        ]);

        GeneratedUrl::create([
            'company_id' => $company->id,
            'user_id' => $member1->id,
            'long_url' => 'https://member-one.com',
            'short_url' => 'member1',
        ]);

        GeneratedUrl::create([
            'company_id' => $company->id,
            'user_id' => $member2->id,
            'long_url' => 'https://member-two.com',
            'short_url' => 'member2',
        ]);

        $response = $this->actingAs($member1)->get('/dashboard');

        $response->assertSee('https://member-one.com');
        $response->assertDontSee('https://member-two.com');
    }

    public function test_short_url_redirects_to_original_url(): void
    {
        $company = Company::create([
            'company_name' => 'Test Company',
        ]);

        $user = User::create([
            'company_id' => $company->id,
            'name' => 'Test User',
            'email' => 'user@test.com',
            'password' => bcrypt('password'),
            'role' => 'member',
        ]);

        GeneratedUrl::create([
            'company_id' => $company->id,
            'user_id' => $user->id,
            'long_url' => 'https://google.com',
            'short_url' => 'abc123',
        ]);

        $response = $this->get('/abc123');

        $response->assertRedirect('https://google.com');
    }
}