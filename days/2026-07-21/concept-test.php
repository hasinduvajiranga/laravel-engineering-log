// File: tests/Models/UserTest.php

namespace Tests\Models;

use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    public function test_user_has_correct_casts()
    {
        $user = new User();
        $this->assertInstanceOf(Cache::class, $user->getBio());
        $this->assertTrue($user->password);
    }

    public function test_get_bio_method_returns_correct_html()
    {
        $user = new User();
        $user->bio = '<p>Hello World!</p>';
        $user->save();

        $expected = '<p>Hello World!</p>';

        $result = $user->getBio();

        $this->assertEquals($expected, $result);
    }
}