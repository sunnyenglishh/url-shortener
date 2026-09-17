<?php

namespace Tests\Unit;

use App\Models\Company;
use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShortUrlTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_uses_short_code_as_the_route_key_name(): void
    {
        $shortUrl = new ShortUrl();

        $this->assertSame('short_code', $shortUrl->getRouteKeyName());
    }

    public function test_admin_and_member_can_create_short_urls(): void
    {
        foreach ([User::ROLE_ADMIN, User::ROLE_MEMBER] as $role) {
            $company = Company::create(['name' => 'Example Company']);

            $user = User::factory()->create([
                'company_id' => $company->id,
                'role' => $role,
            ]);

            $this->actingAs($user);

            $response = $this->post(route('short-urls.store'), [
                'original_url' => 'https://example.com/'.$role,
            ]);

            $response->assertRedirect();
            $response->assertSessionHas('success', 'Short URL created successfully.');

            $this->assertDatabaseHas('short_urls', [
                'user_id' => $user->id,
                'company_id' => $company->id,
                'original_url' => 'https://example.com/'.$role,
            ]);
        }
    }

    public function test_super_admin_cannot_create_short_urls(): void
    {
        $company = Company::create(['name' => 'Example Company']);

        $user = User::factory()->create([
            'company_id' => $company->id,
            'role' => User::ROLE_SUPER_ADMIN,
        ]);

        $this->actingAs($user);

        $this->post(route('short-urls.store'), [
            'original_url' => 'https://example.com',
        ])->assertForbidden();

        $this->assertDatabaseCount('short_urls', 0);
    }

    public function test_admin_can_only_see_short_urls_for_their_own_company(): void
    {
        $companyA = Company::create(['name' => 'Company A']);
        $companyB = Company::create(['name' => 'Company B']);

        $admin = User::factory()->create([
            'company_id' => $companyA->id,
            'role' => User::ROLE_ADMIN,
        ]);

        $otherUser = User::factory()->create([
            'company_id' => $companyB->id,
            'role' => User::ROLE_MEMBER,
        ]);

        ShortUrl::create([
            'user_id' => $admin->id,
            'company_id' => $companyA->id,
            'original_url' => 'https://company-a.example.com',
            'short_code' => 'abc123',
        ]);

        ShortUrl::create([
            'user_id' => $otherUser->id,
            'company_id' => $companyB->id,
            'original_url' => 'https://company-b.example.com',
            'short_code' => 'def456',
        ]);

        $this->actingAs($admin)
            ->get('/dashboard')
            ->assertOk()
            ->assertSee('https://company-a.example.com')
            ->assertDontSee('https://company-b.example.com');
    }

    public function test_member_can_only_see_short_urls_created_by_themselves(): void
    {
        $company = Company::create(['name' => 'Example Company']);

        $memberOne = User::factory()->create([
            'company_id' => $company->id,
            'role' => User::ROLE_MEMBER,
        ]);

        $memberTwo = User::factory()->create([
            'company_id' => $company->id,
            'role' => User::ROLE_MEMBER,
        ]);

        ShortUrl::create([
            'user_id' => $memberOne->id,
            'company_id' => $company->id,
            'original_url' => 'https://me.example.com',
            'short_code' => 'member1',
        ]);

        ShortUrl::create([
            'user_id' => $memberTwo->id,
            'company_id' => $company->id,
            'original_url' => 'https://other.example.com',
            'short_code' => 'member2',
        ]);

        $this->actingAs($memberOne)
            ->get('/dashboard')
            ->assertOk()
            ->assertSee('https://me.example.com')
            ->assertDontSee('https://other.example.com');
    }

    public function test_short_urls_are_publicly_resolvable_and_redirect_to_the_original_url(): void
    {
        $company = Company::create([
            'name' => 'Example Company',
        ]);

        $user = User::factory()->create([
            'company_id' => $company->id,
            'role' => User::ROLE_MEMBER,
        ]);

        $this->actingAs($user);

        $response = $this->post(route('short-urls.store'), [
            'original_url' => 'https://example.com',
        ]);

        $response->assertRedirect();

        $shortUrl = ShortUrl::query()->first();

        $this->get('/'.$shortUrl->short_code)
            ->assertRedirect('https://example.com');
    }
}
