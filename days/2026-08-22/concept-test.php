// Test the custom scoping trait using Pest
use App\Models\User;
use Tests\TestCase;

class EloquentModelScoperTest extends TestCase
{
    public function testCustomScopingTrait()
    {
        // Create a new user with some sample data
        $user = User::create(['name' => 'John Doe', 'post_id' => 1, 'created_at' => now()->subDays(5)]);
        $user->posts()->create(['title' => 'Sample Post 1']);

        // Test the scopeWithinRange method on the user model
        $query = User::query();
        $result = $query->withinRange('created_at', now()->subDays(2), now());
        self::assertCount(1, $result);

        // Reset the query and test the scopeByPostCreated method
        $query->reset();

        $result = $query->byPostCreated(now()->subDays(5), now());
        self::assertCount(1, $result);
    }

    public function testInvalidScoping()
    {
        // Create a new user with some sample data
        $user = User::create(['name' => 'John Doe', 'post_id' => 1, 'created_at' => now()->subDays(5)]);
        $user->posts()->create(['title' => 'Sample Post 1']);

        // Test that an error is thrown when trying to use the scopeWithInvalidRange method
        $this->expectException(\InvalidArgumentException::class);
        User::query()->scopeWithInvalidRange('created_at', 'now');
    }
}