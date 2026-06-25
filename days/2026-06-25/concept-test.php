// FileUploaderTest.php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;
use App\Http\Controllers\FileUploader;
use Tests\TestCase;

class FileUploaderTest extends TestCase
{
    use RefreshDatabase, WithFaker, WithoutMiddleware;

    /**
     * Test that the uploadFile method stores a file in public storage.
     *
     * @test
     */
    public function test_upload_file_stores_in_public_storage()
    {
        // Make a POST request with a sample file attached
        $response = $this->postJson('/upload-file', [
            'file' => file_get_contents(__DIR__ . '/storage/test.txt'),
        ]);

        // Assert that the response contains a URL to the uploaded file
        $response->assertStatus(200);
        $response->assertJson(['url' => '/uploads/test.txt']);
    }

    /**
     * Test that validation errors are returned when uploading an invalid file.
     *
     * @test
     */
    public function test_validation_errors_are_returned()
    {
        // Make a POST request with a non-existent file attached
        $response = $this->postJson('/upload-file', [
            'file' => null,
        ]);

        // Assert that the response contains validation errors
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('file');
    }
}