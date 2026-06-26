// File: app/Http/Controllers/DownloadController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;

class DownloadController extends Controller
{
    public function downloadFile(Request $request)
    {
        // Set the content type and disposition of the response
        $response = Response::make(file_get_contents('path/to/downloadable/file'), 200, [
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="example.txt"'
        ]);

        return $response;
    }
}