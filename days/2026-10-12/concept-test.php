// File: tests/Http/Resources/UserResourceTest.php

namespace Tests\Http\Resources;

use App\Http\Resources\UserResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use App\Models\User;
use Mockery;

class UserResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_resource()
    {
        $user = new User();
        $user->name = 'John Doe';
        $user->email = 'john.doe@example.com';

        $userResource = new UserResource($user);

        $expectedResponse = [
            'id' => 1,
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
        ];

        $this->assertEquals($expectedResponse, (array) $userResource);
    }

    public function test_collection_user_resource()
    {
        factory(User::class, 2)->create();

        $users = collect([
            new User(),
            new User(),
        ]);

        $userCollection = new UserResource($users);

        $expectedResponse = [
            'data' => [
                [
                    'id' => 1,
                    'name' => null,
                    'email' => null,
                ],
                [
                    'id' => 2,
                    'name' => null,
                    'email' => null,
                ],
            ],
        ];

        $this->assertEquals($expectedResponse, (array) $userCollection);
    }
}