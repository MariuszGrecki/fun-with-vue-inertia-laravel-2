<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_register_and_is_logged_in_as_client()
    {
        $response = $this->post(route('user-account.store'), [
            'name' => 'Jan Kowalski',
            'email' => 'jan@example.com',
            'password' => 'secret-password',
            'password_confirmation' => 'secret-password',
        ]);

        $response->assertRedirect(route('listing.index'));
        $this->assertAuthenticated();

        $user = User::where('email', 'jan@example.com')->firstOrFail();
        $this->assertSame(UserRole::client, $user->role);
    }

    public function test_registration_requires_unique_email()
    {
        User::factory()->create(['email' => 'jan@example.com']);

        $response = $this->post(route('user-account.store'), [
            'name' => 'Jan Kowalski',
            'email' => 'jan@example.com',
            'password' => 'secret-password',
            'password_confirmation' => 'secret-password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_user_can_log_in_with_correct_credentials()
    {
        $user = User::factory()->create();

        $response = $this->post(route('auth.login.store'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('listing.index'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_log_in_with_wrong_password()
    {
        $user = User::factory()->create();

        $response = $this->post(route('auth.login.store'), [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_user_can_log_out()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->delete(route('auth.logout'));

        $response->assertRedirect();
        $this->assertGuest();
    }
}
