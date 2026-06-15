// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    public function getJsonData(Request $request)
    {
        // Sample data
        $data = [
            'id' => 1,
            'name' => 'John Doe',
            'email' => 'john@example.com'
        ];

        // Set the content type to application/json
        $response = Response::json($data, 200);

        // Add a custom JSON response format with timestamps and indentation
        $response->header('Content-Type', 'application/json');
        $response->setEncodingOptions(JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        $response->setHeader('X-JSON-Format', 'timestamp:2023-02-20T14:30:00Z');

        return $response;
    }
}