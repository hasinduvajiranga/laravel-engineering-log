// File: tests/Feature/UserControllerTest.php
namespace Tests\Feature;

use App\Http\Controllers\UserController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Request;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_index_compressed()
    {
        // Create some sample data for testing.
        factory(User::class, 5)->create();

        $response = $this->actingAs(Request::create('/users', 'GET'))
            ->json($this->get('api/users'));

        // Assert the response contains compressed data.
        $compressedData = substr($response->body, strpos($response->body, "\x1f\x8b") + 2);
        $uncompressedData = unserialize(gzuncompress($compressedData));

        // Assert the compression did not affect the actual data.
        $this->assertEquals($uncompressedData, User::all()->toArray());
    }
}