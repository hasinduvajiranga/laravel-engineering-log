// tests/Models/UserTest.php

namespace Tests\Models;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testToArray()
    {
        // Create a new user instance
        $user = new User(['name' => 'John Doe', 'email' => 'john@example.com']);

        // Serialize the user instance to an array
        $serializedUser = json_encode($user->toArray());

        // Assert that the serialization format is correct
        self::assertEquals([
            'id' => 1,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'is_active' => true,
        ], json_decode($serializedUser, true));

        // Test that custom attributes are correctly serialized
        $user->status = 0;
        $serializedUser = json_encode($user->toArray());

        self::assertEquals([
            'id' => 1,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'is_active' => false,
        ], json_decode($serializedUser, true));
    }
}