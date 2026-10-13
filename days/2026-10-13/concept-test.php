// tests/Feature/UserControllerTest.php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        factory(User::class, 10)->create();

        $response = $this->get('/api/users');

        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'email'],
            ],
            'meta' => [
                'current_page' => 1,
                'total_pages' => 1,
                'per_page' => 10,
                'from' => 1,
                'to' => 10,
            ],
        ]);
    }

    public function test_index_with_perpage_parameter()
    {
        factory(User::class, 5)->create();

        $response = $this->get('/api/users?per_page=3');

        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'email'],
            ],
            'meta' => [
                'current_page' => 1,
                'total_pages' => 2,
                'per_page' => 3,
                'from' => 1,
                'to' => 3,
            ],
        ]);
    }

    public function test_show_user()
    {
        $user = User::factory()->create();

        $response = $this->get('/api/users/' . $user->id);

        $response->assertJsonStructure([
            'data' => [
                'name',
                'email',
            ],
        ]);
    }
}