// File: tests/Unit/EloquentRelationshipTest.php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;

class EloquentRelationshipTest extends TestCase
{
    use DatabaseMigrations, WithoutMiddleware;

    public function test_hasMany()
    {
        $user = User::factory()->create();

        // Retrieve the user's posts using eager loading (lazy loaded)
        $posts = $user->posts;

        // Assert that the relationship is lazy loaded
        $this->assertInstanceOf(HasMany::class, $posts);

        // Verify that the posts are not retrieved from the database yet
        Schema::hasTable('posts', function ($table) {
            return $table->hasColumn('user_id');
        });

        // Retrieve the user's posts and verify that they have been fetched from the database
        $user->load('posts');

        Schema::hasTable('posts', function ($table) {
            return $table->hasColumn('user_id');
        });
    }

    public function test_belongsToMany()
    {
        $post = Post::factory()->create();
        $user = User::factory()->create();

        // Attach the user to the post
        $post->users()->attach($user->id);

        // Verify that the relationship is lazy loaded
        $this->assertInstanceOf(BelongsToMany::class, $post->user());

        // Verify that the user has been attached to the post
        $this->assertTrue($post->users()->contains($user->id));
    }
}