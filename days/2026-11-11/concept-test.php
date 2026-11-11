// tests/Feature/UserControllerTest.php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Request;
use Laravel\Lumen\TestCase;
use App\Models\User;
use App\Http\Controllers\UserController;

class UserControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testFindUsersWithTimeout()
    {
        // Set up a request with the timeout set to 30 seconds
        $request = Request::create('/users', 'GET');

        $request->request->set('timeout', 30);

        // Call the index method of the UserController
        $response = app(UserController::class)->index($request);

        // Verify that the response has a JSON body and is 200 OK
        $this->assertEquals(200, $response->status());

        // Verify that the response contains the users with the specified timeout
        $usersResponse = json_decode($response->body(), true);
        $this->assertCount(2, $usersResponse['data']);
    }
}