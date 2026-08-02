// tests/Unit\Models\UserTest.php

namespace Tests\Unit\Models;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testHiddenAttributesAreHidden()
    {
        $user = new User(['name' => 'John Doe', 'email' => 'john@example.com']);

        $this->assertEquals(['name', 'email'], (array) $user->toArray());

        // Additional tests can be added here to validate the hidden attributes
    }

    public function testPasswordIsHidden()
    {
        $user = new User(['name' => 'John Doe', 'password' => 'secret']);

        $this->assertNull($user->password);

        $this->assertEquals(['name', 'email'], (array) $user->toArray());

        // Additional tests can be added here to validate the password attribute
    }
}