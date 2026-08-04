// tests/Models/UserTest.php

namespace Tests\Models;

use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    public function testGetAndSetCreatedAt()
    {
        $user = new User();
        $user->createAt('2022-01-01 12:00:00');

        $this->assertEquals(new DateTime('2022-01-01 12:00:00'), $user->created_at);

        $user->created_at = '2022-01-02 13:00:00';
        $user->save();

        $this->assertEquals(new DateTime('2022-01-02 13:00:00'), $user->created_at);
    }
}

class PostTest extends TestCase
{
    public function testGetAndSetPublishedAt()
    {
        $post = new Post();
        $post->published_at('2022-01-01 12:00:00');

        $this->assertEquals(new Carbon('2022-01-01 12:00:00'), $post->published_at);

        $post->published_at('2022-01-02 13:00:00');
        $post->save();

        $this->assertEquals(new Carbon('2022-01-02 13:00:00'), $post->published_at);
    }
}