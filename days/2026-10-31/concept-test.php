// tests/UserControllerTest.php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testGetUsersReturnsCachedResponse()
    {
        User::factory()->count(1)->create();

        $response = $this->getJson(route('users.index'));

        $response->assertSeeJsonStructure(['data']);
        $response->assertOk();

        $this->assertEquals(1, Cache::rememberForever('user-cache', function () {
            return User::where('name', 'John Doe')->first()->id;
        }));
    }

    public function testGetUsersWithIfNoneMatchReturnsCachedResponse()
    {
        User::factory()->count(1)->create();

        $response = $this->getJson(route('users.index'))->withHeaders(['If-None-Match' => '123']);

        $response->assertSeeJsonStructure(['data']);
        $response->assertOk();

        $this->assertEquals(1, Cache::rememberForever('user-cache', function () {
            return User::where('name', 'John Doe')->first()->id;
        }));

        $response = $this->getJson(route('users.index'))->withHeaders(['If-None-Match' => '456']);

        $response->assertSeeJsonStructure(['data']);
        $response->assertOk();

        $this->assertEquals(1, Cache::rememberForever('user-cache', function () {
            return User::where('name', 'John Doe')->first()->id;
        }));
    }

    public function testGetUsersWithoutIfNoneMatchDoesNotCache()
    {
        User::factory()->count(1)->create();

        $response = $this->getJson(route('users.index'));

        $response->assertSeeJsonStructure(['data']);
        $response->assertOk();

        $this->assertEquals(0, Cache::rememberForever('user-cache', function () {
            return User::where('name', 'John Doe')->first()->id;
        }));
    }
}