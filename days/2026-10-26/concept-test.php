// tests/Http/Controllers/EloquentApiControllerTest.php

namespace Tests\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\EloquentApiController;
use App\Models\User;
use PHPUnit\Framework\TestCase;

class EloquentApiControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testValidateAgainstModelRules()
    {
        $model = new User();

        $this->validatorClass = EloquentModelValidator::class;
        $controller = new EloquentApiController();

        // Mock Request instance to have data for validation
        Request::fake()->all(['name' => 'John Doe', 'email' => 'john@example.com']);

        $response = $controller->getEloquentData(Request::instance());

        $this->assertEquals(true, $response['success']);
    }

    public function testValidateAgainstRequestRules()
    {
        // Mock Request instance to have data for validation
        Request::fake()->all(['name' => 'John Doe', 'email' => 'john@example.com']);

        $controller = new EloquentApiController();

        $this->validatorClass = EloquentValidator::class;

        $response = $controller->getEloquentData(Request::instance());

        $this->assertEquals(true, $response['success']);
    }
}