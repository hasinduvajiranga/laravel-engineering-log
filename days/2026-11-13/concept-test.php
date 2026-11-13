// tests/Feature/UserControllerTest.php
namespace Tests\Feature;

use App\Http\Controllers\UserController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_index()
    {
        $response = $this->get('/users');
        $response->assertStatus(200);
    }

    public function test_show()
    {
        $user = factory(User::class)->create();
        $response = $this->get('/users/' . $user->id);
        $response->assertStatus(200);
        $response->assertJson(['name' => $user->name]);
    }

    public function test_store()
    {
        $response = $this->post('/users', [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => $this->faker->password,
        ]);

        $response->assertStatus(201);
        $response->assertJson(['id' => 1]);
    }

    public function test_update()
    {
        $user = factory(User::class)->create();
        $response = $this->put('/users/' . $user->id, [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => $this->faker->password,
        ]);

        $response->assertStatus(200);
    }

    public function test_destroy()
    {
        $user = factory(User::class)->create();
        $response = $this->delete('/users/' . $user->id);

        $response->assertStatus(204);
    }
}