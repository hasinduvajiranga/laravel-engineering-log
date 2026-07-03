// tests/DirectiveControllerTest.php

namespace Tests\Feature;

use App\Http\Controllers\DirectiveController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Blade;
use Pest\Laravel\Tests\TestCase;

class DirectiveControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function a_directive_is_created()
    {
        // Create a test user and token
        $user = factory(User::class)->create();
        $token = $user->createToken('test-token')->plainTextToken;

        // Set the user and token as middleware in the controller
        $this->actingAs($user)
            ->withAuthCredentials([
                'token' => $token,
            ])
            ->get(route('directives.create'));
    }

    /**
     * @test
     */
    public function a_directive_is_valid()
    {
        // Create a test user and token
        $user = factory(User::class)->create();
        $token = $user->createToken('test-token')->plainTextToken;

        // Set the user and token as middleware in the controller
        $this->actingAs($user)
            ->withAuthCredentials([
                'token' => $token,
            ])
            ->post(route('directives.create'), [
                'name' => 'my-directive',
                'content' => 'This is a test directive.',
            ]);

        // Assert that the response contains the expected data
        $this->assertResponseJson([
            'directive' => 'my_directive => This is a test directive.',
        ]);
    }
}