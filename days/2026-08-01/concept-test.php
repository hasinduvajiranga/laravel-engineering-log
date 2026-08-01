// tests/Unit/EloquentModelSerializationTest.php

namespace Tests\Unit\EloquentModelSerialization;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class EloquentModelSerializationTest extends TestCase
{
    use DatabaseMigrations, WithoutMiddleware;

    public function testEloquentModelsCanBeSerialized()
    {
        $user = new User();
        $user->name = 'John Doe';
        $user->email = 'john@example.com';

        $serializedUser = json_encode($user);

        $this->assertJsonStructure(['name', 'email']);

        $post = new Post();
        $post->title = 'Hello World!';
        $post->content = 'This is a test post.';

        $serializedPost = json_encode($post);

        $this->assertJsonStructure(['title', 'content']);
    }

    public function testEloquentRelationshipsCanBeSerialized()
    {
        $user = new User();
        $user->name = 'John Doe';
        $user->email = 'john@example.com';

        $post = new Post();
        $post->title = 'Hello World!';
        $post->content = 'This is a test post.';
        $post->user_id = 1;

        $user->posts()->save($post);

        $serializedUserWithPost = json_encode($user);

        $this->assertJsonStructure(['name', 'email', 'posts']);
    }

    public function testEloquentModelSerializationOptionsCanBeConfigured()
    {
        config(['jsonSerializationDepth' => 5]);

        $user = new User();
        $user->name = 'John Doe';
        $user->email = 'john@example.com';

        $serializedUser = json_encode($user, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        $this->assertJsonStructure(['name', 'email'], ['name', 'email']);

        config(['jsonSerializationDepth' => 10]);
    }
}