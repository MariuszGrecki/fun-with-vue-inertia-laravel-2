<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_unverified_user_is_redirected_to_the_verification_notice()
    {
        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)->get(route('listing.create'));

        $response->assertRedirect(route('verification.notice'));
    }

    public function test_verified_user_can_access_a_protected_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('listing.create'));

        $response->assertOk();
    }
}
