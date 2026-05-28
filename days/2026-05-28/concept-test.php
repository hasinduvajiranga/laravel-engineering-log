// tests/Feature/FallbackControllerTest.php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\TestCase;

class FallbackControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test that a 404 response is returned when no matching route is found.
     *
     * @return void
     */
    public function testHandleNoMatchingRoute()
    {
        $this->actingAs($this->user());
        $response = $this->get('/non-existent-route');
        $response->assertStatus(404);
    }

    /**
     * Test that a fallback route is used when no matching route is found.
     *
     * @return void
     */
    public function testHandleFallbackRoute()
    {
        Route::group(['as' => 'fallback'], function () {
            Route::get('/fallback', function () {
                return response()->json(['message' => 'Fallback Response']);
            });
        });

        $this->actingAs($this->user());
        $response = $this->get('/non-existent-route');
        $response->assertStatus(302);
        $response->assertSee('fallback');
    }

    /**
     * Test that a 404 response is returned when the request method does not match.
     *
     * @return void
     */
    public function testHandleInvalidMethod()
    {
        Route::get('/non-existent-route', function () {
            // This route will never be reached
        });

        $this->actingAs($this->user());
        $response = $this->post('/non-existent-route');
        $response->assertStatus(404);
    }
}