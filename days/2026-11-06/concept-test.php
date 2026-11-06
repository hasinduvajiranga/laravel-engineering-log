// tests/Http/ControllerTest.php

namespace Tests\Http\Controllers;

use App\Http\Controllers\FileController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Laravel\dumper\nodeDump;
use Tests\TestCase;

class FileControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testDownloadFile()
    {
        // create a new file model
        $file = new FileModel();
        $file->name = 'example.pdf';
        $file->path = 'path/to/example.pdf';
        $file->type = 'pdf';

        $this->saveChanges();

        // send the download request
        $response = $this->getJson('/download/file/' . $file->id);
        $response->assertStatus(200);

        // verify file contents match expected output
        $this->assertEquals('path/to/example.pdf', $response->header('Content-Disposition'));
    }

    public function testDownloadFileNotFound()
    {
        // send the download request with a non-existent id
        $response = $this->getJson('/download/file/999');
        $response->assertStatus(404);
        $response->assertJson(['message' => 'File not found']);
    }
}