// tests/Http/EloquentClientTest.php

namespace Tests\Http;

use App\Http\EloquentHttpClient;
use Pest\MockFactory\MockFactory;
use PHPUnit\Framework\TestCase;

class EloquentHttpClientTest extends TestCase
{
    private $mockClient;

    public function setUp(): void
    {
        parent::setUp();

        $this->mockClient = new MockFactory();
        $this->mockClient->mock(Http::class);
    }

    public function testGet()
    {
        $client = new EloquentHttpClient('https://example.com/api');
        $response = $client->get('/users');

        $this->assertInstanceOf(Http\Response::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testPost()
    {
        $client = new EloquentHttpClient('https://example.com/api');
        $data = ['name' => 'John Doe', 'email' => 'john@example.com'];

        $response = $client->post('/users', $data);

        $this->assertInstanceOf(Http\Response::class, $response);
        $this->assertEquals(201, $response->getStatusCode());
    }
}