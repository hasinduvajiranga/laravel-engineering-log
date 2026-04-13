// File: app/Http/Client.php

namespace App\Http\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Support\Facades\Http;

class HttpClient
{
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('app.url'),
            'timeout'  => 5.0,
        ]);
    }

    public function get($url)
    {
        try {
            return $this->client->get($url);
        } catch (ConnectException $e) {
            throw new Exception("Failed to connect to $url: " . $e->getMess
$e->getMessage());
        }
    }

    public function post($url, $data = [])
    {
        try {
            return $this->client->post($url, ['json' => $data]);
        } catch (ConnectException $e) {
            throw new Exception("Failed to connect to $url: " . $e->getMess
$e->getMessage());
        }
    }

    public function put($url, $data = [])
    {
        try {
            return $this->client->put($url, ['json' => $data]);
        } catch (ConnectException $e) {
            throw new Exception("Failed to connect to $url: " . $e->getMess
$e->getMessage());
        }
    }

    public function delete($url)
    {
        try {
            return $this->client->delete($url);
        } catch (ConnectException $e) {
            throw new Exception("Failed to connect to $url: " . $e->getMess
$e->getMessage());
        }
    }
}