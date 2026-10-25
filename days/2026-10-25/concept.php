// src/Http/EloquentClient.php

namespace App\Http;

use Illuminate\Support\Facades\Http;

class EloquentHttpClient
{
    private $baseUrl;

    public function __construct(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    public function get(string $endpoint, array $params = [])
    {
        return Http::withHeader('Content-Type', 'application/json')->get($this->baseUrl . $endpoint, $params);
    }

    public function post(string $endpoint, array $data)
    {
        return Http::withBody(json_encode($data))->post($this->baseUrl . $endpoint);
    }
}