// tests/ExampleTest.php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testEloquentN1ProblemDetection()
    {
        // Create a new user with some data
        $user = User::factory()->create(['name' => 'John Doe', 'email' => 'john@example.com']);

        // Get the user and load its comments in a single query using eager loading
        $comments = $user->load('comments')->comments();

        // Assert that the number of comments is 2
        $this->assertEquals(2, count($comments));

        // Now let's introduce the N+1 problem by not using eager loading
        $commentsN1 = [];

        foreach ($user->comments as $comment) {
            $commentData = DB::table('comments')->where('id', $comment->id)->first();
            $commentsN1[] = ['content' => $commentData['content']];
        }

        // Assert that the number of comments is still 2
        $this->assertEquals(2, count($commentsN1));
    }
}