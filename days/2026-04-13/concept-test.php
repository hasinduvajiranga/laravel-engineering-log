// File: tests/HttpClientTest.php

namespace Tests\Http;

use App\Http\Client\HttpClient;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Foundation\Testing\TestCase;

class HttpClientTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->client = new HttpClient();
    }

    public function testGetSuccess()
    {
        $response = $this->client->get('https://jsonplaceholder.typicode.co
$this->client->get('https://jsonplaceholder.typicode.com/todos/1');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertInstanceOf(json_decode($response->getBody()->getConten
$this->assertInstanceOf(json_decode($response->getBody()->getContents(), tr
true), $response->getBody()->getContents());
    }

    public function testGetFailure()
    {
        $this->expectException(RequestException::class);
        $this->client->get('https://non-existent-url.com');
    }

    public function testPostSuccess()
    {
        $data = ['title' => 'foo', 'body' => 'bar'];
        $response = $this->client->post('https://jsonplaceholder.typicode.c
$this->client->post('https://jsonplaceholder.typicode.com/posts', $data);
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertInstanceOf(json_decode($response->getBody()->getConten
$this->assertInstanceOf(json_decode($response->getBody()->getContents(), tr
true), json_decode($response->getBody()->getContents(), true));
    }

    public function testPostFailure()
    {
        $this->expectException(RequestException::class);
        $this->client->post('https://non-existent-url.com', ['title' => 'fo
'foo', 'body' => 'bar']);
    }

    public function testPutSuccess()
    {
        $data = ['title' => 'foo', 'body' => 'bar'];
        $response = $this->client->put('https://jsonplaceholder.typicode.co
$this->client->put('https://jsonplaceholder.typicode.com/posts/1', $data);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertInstanceOf(json_decode($response->getBody()->getConten
$this->assertInstanceOf(json_decode($response->getBody()->getContents(), tr
true), json_decode($response->getBody()->getContents(), true));
    }

    public function testPutFailure()
    {
        $this->expectException(RequestException::class);
        $this->client->put('https://non-existent-url.com', ['title' => 'foo
'foo', 'body' => 'bar']);
    }

    public function testDeleteSuccess()
    {
        $response = $this->client->delete('https://jsonplaceholder.typicode
$this->client->delete('https://jsonplaceholder.typicode.com/todos/1');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertInstanceOf(json_decode($response->getBody()->getConten
$this->assertInstanceOf(json_decode($response->getBody()->getContents(), tr
true), json_decode($response->getBody()->getContents(), true));
    }

    public function testDeleteFailure()
    {
        $this->expectException(RequestException::class);
        $this->client->delete('https://non-existent-url.com');
    }
}