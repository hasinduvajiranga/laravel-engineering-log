// File: tests/Http/Controllers/SubdomainControllerTest.php

namespace Tests\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use App\Http\Controllers(SubdomainController);
use Illuminate\Http\Request;

class SubdomainControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Route::get('{subdomain?}', [SubdomainController::class, 'index'])->name('subdomain.index');
    }

    public function testInvalidSubdomain()
    {
        $response = $this->patch('/invalid-subdomain', ['subdomain' => 'invalid']);
        $response->assertStatus(400);
        $response->assertJson(['error' => 'Invalid subdomain']);
    }

    public function testValidBlogSubdomain()
    {
        $response = $this->get('/blog');
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Blog request handled successfully']);
    }

    public function testValidApiSubdomain()
    {
        $response = $this->get('/api');
        $response->assertStatus(200);
        $response->assertJson(['message' => 'API request handled successfully']);
    }
}