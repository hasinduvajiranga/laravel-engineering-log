// File: tests/Models/UserTest.php

namespace Tests\Models;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    public function testUserHasFactory()
    {
        $this->assertInstanceOf(UserFactory::class, $this->user->factory);
    }

    public function testUserHasfillableColumns()
    {
        $fillable = $this->user->fillable;
        $expectedFillable = [
            'name',
            'email',
            'password',
        ];
        $this->assertEquals($expectedFillable, $fillable);
    }

    public function testUserHasAssociatedModel()
    {
        $post = factory(Post::class)->create(['user_id' => $this->user->id]);
        $this->assertInstanceOf(User::class, $post->owner());
    }
}