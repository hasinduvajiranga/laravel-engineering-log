// Test the polymorphic relationships using PHPUnit
namespace Tests\Models;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

class PolymorphicRelationshipTest extends TestCase
{
    public function testUserHasPosts()
    {
        // Create a new User instance
        $user = factory(User::class)->create();

        // Get the posts associated with the user
        $posts = $user->posts()->get();

        // Verify that there is at least one post associated with the user
        self::assertGreaterThanOrEqual(1, count($posts));
    }

    public function testUserHasComments()
    {
        // Create a new User instance
        $user = factory(User::class)->create();

        // Get the comments associated with the user
        $comments = $user->comments()->get();

        // Verify that there is at least one comment associated with the us
user
        self::assertGreaterThanOrEqual(1, count($comments));
    }

    public function testPostHasUserAndComments()
    {
        // Create a new Post instance
        $post = factory(Post::class)->create();

        // Get the user and comments associated with the post
        $user = $post->user()->first();
        $comments = $post->comments()->get();

        // Verify that there is a user and at least one comment associated 
with the post
        self::assertNotNull($user);
        self::assertGreaterThanOrEqual(1, count($comments));
    }

    public function testCommentHasPost()
    {
        // Create a new Comment instance
        $comment = factory(Comment::class)->create();

        // Get the post associated with the comment
        $post = $comment->posts()->first();

        // Verify that there is a post associated with the comment
        self::assertNotNull($post);
    }
}