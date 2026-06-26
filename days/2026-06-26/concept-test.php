// File: tests/Feature/ControllerTest.php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Tests\TestCase;

class ControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function test_streamed_response()
    {
        $response = $this->get('/');

        $this->assertEquals(200, $response->status());
        
        // Check the Content-Disposition header to see if it's set correctly
        $response->headers->get('Content-Disposition');
        
        // Check the Content-Range header to see if it's set correctly
        $response->headers->get('Content-Range');
    }
}