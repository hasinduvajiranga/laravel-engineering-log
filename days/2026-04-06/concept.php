// src/Http/Client.php

namespace App\Http;

use Illuminate\Support\Facades\Http;

class HttpClient
{
    private $client;

    public function __construct()
    {
        $this->client = new Http\Client();
    }

    public function sendRequest($method, string $uri, array $data = [], str
string $header = null)
    {
        return $this->client->request($method, $uri, ['body' => $data, 'hea
'headers' => [$header ?? {}]]);
    }
}