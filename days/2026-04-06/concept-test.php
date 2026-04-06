// tests/Http/ClientTest.php

namespace Tests\Http;

use App\Http\HttpClient;
use Tests\TestCase;

class HttpClientTest extends TestCase
{
    public function testSendRequest()
    {
        $client = new HttpClient();

        $response = $client->sendRequest('GET', '/api/users');

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testSendRequestWithHeaders()
    {
        $client = new HttpClient();
        $headers = ['Authorization' => 'Bearer 12345'];

        $response = $client->sendRequest('GET', '/api/users', null, $header
$headers);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($headers['Authorization'], $response->getHeader
$response->getHeaders()['Authorization']);
    }

    public function testSendRequestWithFormData()
    {
        $client = new HttpClient();
        $data = ['name' => 'John Doe', 'email' => 'john@example.com'];

        $response = $client->sendRequest('POST', '/api/users', $data);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertContains($data['name'], json_decode($response->getBody
json_decode($response->getBody(), true));
    }
}