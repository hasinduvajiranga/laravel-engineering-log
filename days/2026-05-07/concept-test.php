// tests/Feature/UserControllerTest.php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Nova\Test NovaTestCase;
use App\Models\User;
use App\Http\Controllers\UserController;

class UserControllerTest extends NovaTestCase
{
    use RefreshDatabase, WithFaker;

    protected $controller;

    public function setUp(): void
    {
        parent::setUp();

        $this->controller = new UserController();
    }

    public function test_index_is_performant()
    {
        // Test the index method to ensure it returns a response in under 1
100ms
        $request = factory(User::class, 10)->create();
        $response = $this->controller->index(new Request());

        $this->assertResponseIsSuccessful($response);
        $this->assertLessThan(100, $response->timedOut());
    }

    public function test_cache_is_enabled()
    {
        // Test that the cache is enabled
        $request = new Request();
        $users = $this->controller->performanceOptimizer->cacheUsers();

        $this->assertTrue($users instanceof \Illuminate\Support\Collection)
\Illuminate\Support\Collection);
    }
}