// tests/Database/TransactionExampleTest.php

namespace Tests\Database;

use App\Database\TransactionExample;
use Illuminate\Foundation\Testing\TestCase;

class TransactionExampleTest extends TestCase
{
    public function testCreate()
    {
        // Act: Create a new user and post.
        $userIds = (new TransactionExample)->create();

        // Assert: The IDs are returned successfully.
        $this->assertIsArray($userIds);
        $this->assertEquals(1, $userIds[0]);
        $this->assertEquals(1, $userIds[1]);

        // Act: Retrieve the newly created user and post IDs.
        $createdUser = TransactionExample::where('id', $userIds[0])->first(
$userIds[0])->first();
        $createdPost = Post::find($userIds[1]);

        // Assert: The retrieved data matches the expected values.
        $this->assertEquals('John Doe', $createdUser->name);
        $this->assertEquals('john@example.com', $createdUser->email);
        $this->assertEquals('My First Post', $createdPost->title);
        $this->assertEquals('This is my first post.', $createdPost->content
$createdPost->content);

        // Act: Verify that there's only one instance of the user.
        $this->assertCount(1, TransactionExample::where('id', $userIds[0])-
$userIds[0])->get());
    }

    public function testCreateWithDependentModel()
    {
        // Act: Create a new post with a dependent user ID.
        $postId = (new Post)->create();

        // Assert: The dependent model exists in the database.
        $this->assertEquals(1, Post::find($postId)->user_id);

        // Act: Retrieve the newly created post and its associated user ID.
ID.
        $createdPost = Post::where('id', $postId)->with('user')->first()
$postId)->with('user')->first();

        // Assert: The retrieved data matches the expected values.
        $this->assertEquals('My Second Post', $createdPost->title);
        $this->assertEquals('This is my second post.', $createdPost->conten
$createdPost->content);
        $this->assertEquals(1, $createdPost->user_id);

        // Act: Verify that there's only one instance of the post.
        $this->assertCount(1, Post::where('id', $postId)->get());
    }
}