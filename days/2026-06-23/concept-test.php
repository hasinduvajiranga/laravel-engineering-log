// tests/Http/Controllers/UserControllerTest.php

namespace Tests\Http\Controllers;

use App\Http\Controllers\UserController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestSuite;
use Laravel\Dusk\Browser;
use Pest\Laravel\Pest;
use Pest\Laravel\Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase, TestSuite;

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->make(UserController::class)->index();
    }

    public function test_index_returns_all_users()
    {
        return $this->get('/users')
            ->assertStatus(200)
            ->assertJsonCount(count(User::all()));
    }

    public function test_show_user_returns_user_details()
    {
        // Create a user for testing
        User::factory()->create();

        return $this->get('/users/1')
            ->assertStatus(200)
            ->assertJson(['id' => 1, 'name' => 'John Doe']);
    }

    public function test_show_invalid_user_returns_404()
    {
        return $this->get('/users/99999')
            ->assertStatus(404);
    }
}