// tests/Http/RouteTest.php

namespace Tests\Http;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Route;

class RouteTest extends TestCase
{
    use DatabaseMigrations;

    public function testUserValidation()
    {
        $this->actingAs($this->user());
        $this->post('/api/users', new UserRequest(['name' => 'John Doe', 'email' => 'johndoe@example.com']));

        $response = $this->json('GET /users/1');

        $response->assertStatus(404);
    }

    public function testUserValidationError()
    {
        $this->actingAs($this->user());
        $this->post('/api/users', new UserRequest(['name' => '', 'email' => 'johndoe@example.com']));

        $response = $this->json('GET /users/1');

        $response->assertStatus(422);
    }
}