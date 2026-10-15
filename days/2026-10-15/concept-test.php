// tests/ApiControllerTest.php

namespace Tests\Http\Controllers\Api;

use Illuminate\Foundation\Testing\TestCase;
use App\Http\Controllers\Api\Api;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFakerFactory;
use Laravel\Lumen\Tests\TestCase as LumenTestCase;

class ApiControllerTest extends LumenTestCase
{
    use HasFakeUserTrait;
    use HasResponse;

    public function testRateLimited()
    {
        $api = new Api();

        // Test case 1: No requests in the time window, rate limit request processed successfully
        $response = $this->json('POST', 'api/rate-limited', [], ['REMOTE_ADDR' => '192.168.0.1']);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->json('message') == 'Rate limit request processed successfully');

        // Test case 2: Number of requests in the time window exceeds the limit
        RateLimitedAPIRequest::factory()->count($this->maxRequestsPerMinute)->create();
        $response = $this->json('POST', 'api/rate-limited', [], ['REMOTE_ADDR' => '192.168.0.1']);
        $this->assertEquals(429, $response->getStatusCode());
        $this->assertTrue($response->json('message') == 'Rate limit Exceeded');

        // Test case 3: Different IP address, rate limit request processed successfully
        RateLimitedAPIRequest::factory()->count($this->maxRequestsPerMinute)->create();
        $ipAddress = '192.168.0.2';
        $response = $this->json('POST', 'api/rate-limited', [], ['REMOTE_ADDR' => $ipAddress]);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->json('message') == 'Rate limit request processed successfully');
    }
}