// File: tests/Http/DownloadControllerTest.php

namespace Tests\Http;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\DownloadController;

class DownloadControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_download_file()
    {
        $response = $this->get('/download');
        $response->assertStatus(200);
        $this->assertEquals('application/octet-stream', $response->header('Content-Type'));
        $this->assertEquals('attachment; filename="example.txt"', $response->header('Content-Disposition'));
    }

    public function test_download_file_with_filename()
    {
        DownloadController::downloadFile = function () {
            return Response::make(file_get_contents('path/to/downloadable/file'), 200, [
                'Content-Type' => 'application/octet-stream',
                'Content-Disposition' => 'attachment; filename="example.txt"'
            ]);
        };

        $response = $this->get('/download');
        $response->assertStatus(200);
        $this->assertEquals('application/octet-stream', $response->header('Content-Type'));
        $this->assertEquals('attachment; filename="example.txt"', $response->header('Content-Disposition'));
    }

    public function test_download_file_without_filename()
    {
        DownloadController::downloadFile = function () {
            return Response::make(file_get_contents('path/to/downloadable/file'), 200, [
                'Content-Type' => 'application/octet-stream'
            ]);
        };

        $response = $this->get('/download');
        $response->assertStatus(200);
        $this->assertEquals('application/octet-stream', $response->header('Content-Type'));
    }
}