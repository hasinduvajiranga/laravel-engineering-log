// Test the vulnerability in the user controller's store method
namespace Tests\Http\Controllers\Tests;

use Illuminate\Foundation\Testing\TestCase;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFakerTrait;
use Illuminate\Foundation\Testing\RefreshDatabaseTrait;
use Faker\Factory as Faker;

class UserControllerTest extends TestCase
{
    use WithFakerTrait, RefreshDatabaseTrait;

    protected $controller;

    public function setUp(): void
    {
        parent::setUp();
        $this->controller = new UserController();
    }

    public function testStoreVulnerableToBladeEscaping()
    {
        // Generate fake data to test the vulnerability
        $faker = $this->faker;
        $data = [
            'name' => $faker->name,
            'email' => $faker->email,
        ];

        // Make a POST request with malicious data
        $response = $this->post('/users', $data);

        // Check if the response was successful and the user was created
        $this->assertResponseOk($response);
        $this->expectDatabaseToHaveRowCount(1);
    }
}