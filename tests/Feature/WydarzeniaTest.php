<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class WydarzeniaTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_events_successful_response(): void
    {
        $response = $this->get('/events');

        $response->assertStatus(200);
    }

    public function test_the_my_events_unsuccessful_response(): void
    {
        $response = $this->get('/events/my_events');

        $response->assertServerError();
    }

    public function test_the_my_events_logged_with_right_role_response(): void
    {
        $testUser = $this->createUserWithRole('organizer');
        $this->actingAs($testUser);
        $response = $this->get('/events/my_events');
        $testUser->delete();
        $response->assertSuccessful();
    }

    private function createUserWithRole(string $string)
    {
        $user = User::factory()->create();
        // check if role exists
        if (!Role::where('name', 'organizer')->exists()) {
            $this->createRole('organizer');
        }
        $user->assignRole('organizer');
        return $user;
    }

    private function createRole(string $string)
    {
        Role::create([
            'name' => $string,
        ]);
    }
}
