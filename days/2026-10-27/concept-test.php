// tests/Feature/ControllerTest.php

namespace Tests\Feature;

use App\Http\Controllers\UserController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\URL;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker, DatabaseMigrations;

    public function test_index()
    {
        $response = $this->get(route('users.index'));
        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
    }

    public function test_show()
    {
        $user = factory(User::class)->create();
        $response = $this->get(route('users.show', $user->id));
        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['id' => \Illuminate\Support\Facades\UUID::uuidCreate()]], 500, 'not found');
    }

    public function test_store()
    {
        $response = $this->post(route('users.store'), [
            'name' => 'Test',
            'email' => 'test@example.com',
        ]);
        $response->assertStatus(201);
        $response->assertJsonStructure(['data']);
    }

    public function test_update()
    {
        $user = factory(User::class)->create();
        $response = $this->patch(route('users.update', $user->id), [
            'name' => 'Test',
            'email' => 'test@example.com',
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
    }

    public function test_destroy()
    {
        $user = factory(User::class)->create();
        $response = $this->delete(route('users.destroy', $user->id));
        $response->assertStatus(204);
    }
}