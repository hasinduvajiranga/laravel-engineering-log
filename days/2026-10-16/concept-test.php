// In the tests/Feature/CorsTest.php file, we need to test CORS configuration

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CorsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @test
     */
    public function it_returns_the_correct_cors_header()
    {
        $response = $this->get('/api/endpoint', [
            'headers' => [
                'Access-Control-Request-Headers' => '*',
                'Access-Control-RequestMethod' => 'POST',
            ],
        ]);

        $response->assertStatus(200);
        $response->assertHeader('Access-Control-Allow-Origin', '*');
        $response->assertHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->assertHeader('Access-Control-Allow-Headers', '*');
    }

    /**
     * @test
     */
    public function it_returns_the_correct_cors_header_with_origin_set()
    {
        $response = $this->get('/api/endpoint', [
            'headers' => [
                'Origin' => 'https://example.com',
                'Access-Control-Request-Headers' => '*',
                'Access-Control-RequestMethod' => 'POST',
            ],
        ]);

        $response->assertStatus(200);
        $response->assertHeader('Access-Control-Allow-Origin', 'https://example.com');
        $response->assertHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->assertHeader('Access-Control-Allow-Headers', '*');
    }
}