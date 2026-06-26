// File: app/Http/Controllers/Controller.php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function index()
    {
        // Create a new stream wrapper
        $stream = fopen('php://temp', 'r+');
        
        // Get the total number of bytes from the response
        $totalBytes = 1024 * 1024; // 1MB
        
        // Set headers for the streamed response
        Response::header('Content-Disposition: attachment; filename="example.csv"');
        Response::header('Content-Type: text/csv');
        Response::header('Accept-Ranges: bytes');
        
        // Send a chunk of data to the client as a stream
        $chunk = str_repeat(',', 1000);
        fwrite($stream, $chunk);
        
        // Set the chunk size for streaming
        header('Accept-Ranges: bytes');
        header('Content-Range: bytes 1-' . ($totalBytes - 1000) . '/' . $totalBytes);
        
        // Return a Response object with the stream wrapper
        return new Response($stream, 200, [
            'Content-Disposition' => 'attachment; filename="example.csv"',
            'Content-Type' => 'text/csv',
        ]);
    }
}