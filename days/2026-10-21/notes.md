# Eloquent API Testing Patterns

Eloquent, being a popular ORM in Laravel, provides an elegant way to interact with the database. However, when it comes to testing APIs, we need to ensure that our tests cover all the necessary aspects of the API.

## Creating a User Model

Firstly, let's create a `User` model using Eloquent:
```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
```

## Creating a Post Model

Similarly, let's create a `Post` model using Eloquent:
```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
```

## Testing the User API

Now, let's create a test class for the `User` model:
```php
namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Laravel Sanctum;
use Pest\Laravel\Pest;
use Pest\Laravel\Tests\WithPest;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker, WithPest;

    public function testCreateUser()
    {
        $user = factory(User::class)->create();

        // Assert user ID and email are set correctly
        $this->assertNotNull($user->id);
        $this->assertEquals('john.doe@example.com', $user->email);

        // Test API endpoint for user creation
        $response = $this->postJson(route('users.store'), ['name' => 'Jane Doe', 'email' => 'jane.doe@example.com']);
        $response->assertStatus(201);
    }

    public function testGetUser()
    {
        $user = factory(User::class)->create();

        // Test API endpoint for user retrieval
        $response = $this->getJson(route('users.show', 1));
        $response->assertStatus(200);

        $response->assertJson([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function testGetUserPosts()
    {
        $user = factory(User::class)->create();

        // Create a post for the user
        $post = Post::factory()->create(['user_id' => $user->id]);

        // Test API endpoint for user's posts
        $response = $this->getJson(route('users.show', 1), ['with' => 'posts']);
        $response->assertStatus(200);

        $response->assertJson([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'posts' => [
                [
                    'title' => $post->title,
                    'content' => $post->content,
                ],
            ],
        ]);
    }
}
```

## Testing the Post API

Similarly, we can create a test class for the `Post` model:
```php
namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Laravel Sanctum;
use Pest\Laravel\Pest;
use Pest\Laravel\Tests\WithPest;

class PostTest extends TestCase
{
    use RefreshDatabase, WithFaker, WithPest;

    public function testCreatePost()
    {
        $post = factory(Post::class)->create();

        // Assert post ID and title are set correctly
        $this->assertNotNull($post->id);
        $this->assertEquals('Hello World!', $post->title);

        // Test API endpoint for post creation
        $response = $this->postJson(route('posts.store'), ['title' => 'New Post', 'content' => 'This is a new post!']);
        $response->assertStatus(201);
    }

    public function testGetPost()
    {
        $post = factory(Post::class)->create();

        // Test API endpoint for post retrieval
        $response = $this->getJson(route('posts.show', 1));
        $response->assertStatus(200);

        $response->assertJson([
            'id' => $post->id,
            'title' => $post->title,
            'content' => $post->content,
        ]);
    }

    public function testGetPostUser()
    {
        $post = factory(Post::class)->create(['user_id' => 1]);

        // Test API endpoint for post's user retrieval
        $response = $this->getJson(route('posts.show', 1), ['with' => 'user']);
        $response->assertStatus(200);

        $response->assertJson([
            'id' => $post->id,
            'title' => $post->title,
            'content' => $post->content,
            'user' => [
                'id' => Post::factory()->create(['user_id' => 1])->id,
                'name' => Post::factory()->create(['user_id' => 1])->name,
                'email' => Post::factory()->create(['user_id' => 1])->email,
            ],
        ]);
    }
}
```

In conclusion, using Eloquent models with Pest or PHPUnit allows us to create robust API tests for our application. By testing the creation, retrieval, and association of models, we can ensure that our API endpoints are working correctly and provide a seamless experience for our users.