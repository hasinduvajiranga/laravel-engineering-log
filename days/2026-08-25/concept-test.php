// File: tests/Unit Tests/UserTest.php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use App\Services\UserService;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userService = new UserService();
    }

    public function testCreateUser()
    {
        $request = factory(UserRequest::class)->make();

        $result = $this->userService->create($request);

        $this->assertDatabaseHas('users', [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);
    }

    public function testCreateUserValidation()
    {
        $request = new UserRequest();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
        ]);

        $this->assertFalse($validator->passes());

        $result = $this->userService->create($request);

        $this->expectException(\Exception::class);
    }
}