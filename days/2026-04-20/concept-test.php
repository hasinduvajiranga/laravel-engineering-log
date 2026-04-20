// tests/UserTest.php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    public function testGetFullNameAttribute()
    {
        $user = new User(['name' => 'john doe']);
        $expected = 'John Doe';
        $this->assertEquals($expected, $user->full_name);
    }

    public function testSetEmailAttribute()
    {
        $user = new User();
        $user->setEmail('JOHN DOE@example.com');
        $this->assertEquals('johndoe@example.com', $user->email);
    }
}