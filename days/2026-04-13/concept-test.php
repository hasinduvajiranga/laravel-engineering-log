<?php

use Tests\TestCase;
use Illuminate\Support\Facades\Gate;

class MiddlewareGroupTest extends TestCase
{
    public function testMiddlewareGroupAuthenticatesUser()
    {
        // Create a user and log in
        $user = App\Models\User::factory()->create();
        $this->actingAs($user);

        // Make the request to the authenticated route
        $response = $this->get(route('authenticated.route'));

        // Verify that the response was successful
        $response->assertOk();

        // Check if the user is authenticated
        Gate::assertAuthenticated();

        // Assert that the middleware group returned a success response
        $this->assertTrue($response->wasSuccessful());
    }

    public function testMiddlewareGroupDoesNotAuthenticateUser()
    {
        // Make the request to the unauthenticated route
        $response = $this->get(route('unauthenticated.route'));

        // Verify that the response was not successful
        $response->assertStatus(401);

        // Assert that the middleware group returned an error response
        $this->assertFalse($response->wasSuccessful());
    }

    public function testRateLimitMiddleware()
    {
        // Create a user and log in with multiple requests within the rate 
limit window
        $user = App\Models\User::factory()->create();
        $this->actingAs($user);

        for ($i = 0; $i < config('rate-limit.limit'); $i++) {
            $response = $this->get(route('rate-limited.route'));
        }

        // Make another request to the rate-limited route
        $response = $this->get(route('rate-limited.route'));

        // Verify that the response was not successful
        $response->assertStatus(429);

        // Assert that the middleware group returned an error response
        $this->assertFalse($response->wasSuccessful());
    }
}