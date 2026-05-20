// tests/Feature/RouteModelBindingTest.php

namespace Tests\Feature;

use App\Models\User;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Sanctum\LaravelPersonalAccessTokenRepository;
use Pest\Laravel\TestCase;
use Pest\Mutation\Stub;

class RouteModelBindingTest extends TestCase
{
    use DatabaseMigrations;

    public function testBinding()
    {
        // Create a user instance and add it to the database.
        $user = User::factory()->create();

        // Update the user's email address and save the changes.
        $user->update(['email' => 'new@example.com']);

        // The show method should return a view with the updated user data.
        $response = $this->getJson(route('users.show', ['id' => $user->id]));
        $response->assertJsonFragment(['data' => [
            'id' => 1,
            'name' => null,
            'email' => 'new@example.com',
            'created_at' => time(),
        ]]);
    }

    public function testUpdate()
    {
        // Create a user instance and add it to the database.
        $user = User::factory()->create();

        // Update the user's email address and save the changes.
        $user->update(['email' => 'new@example.com']);

        // The update method should return a redirect response after updating the user data.
        $response = $this->patchJson(route('users.update', ['id' => $user->id]), [
            'name' => 'New User',
            'email' => 'updated@example.com',
        ]);
        $response->assertRedirect(route('users.index'));
    }
}