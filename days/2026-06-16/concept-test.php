// File: tests/Http/Controllers/ErrorCodeControllerTest.php

namespace Tests\Http\Controllers;

use App\Http\Controllers\ErrorCodeController;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Laravel\Featuredk\Concerns\InteractsWithFakeRequest;
use Pest\Http\Request;
use Tests\TestCase;

class ErrorCodeControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase, WithoutMiddleware, InteractsWithFakeRequest;

    protected $controller;

    public function setUp(): void
    {
        parent::setUp();

        $this->controller = new ErrorCodeController();
    }

    /**
     * @test
     */
    public function test_index_returns_error_codes()
    {
        $response = $this->get('/error-codes');

        $response->assertStatus(200);
        $response->assertJson([
            'success' => false,
            'error_codes' => [
                400 => 'Bad Request',
                401 => 'Unauthorized',
                404 => 'Not Found',
                // Add more error codes as needed
            ],
        ]);
    }

    /**
     * @test
     */
    public function test_show_returns_error_code()
    {
        $response = $this->get('/error-codes/400');

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'error_code' => 400,
            'error_message' => 'Bad Request',
        ]);
    }

    /**
     * @test
     */
    public function test_show_returns_404_when_error_code_not_found()
    {
        $this->get('/error-codes/999');

        $this->assertStatus(404);
    }
}