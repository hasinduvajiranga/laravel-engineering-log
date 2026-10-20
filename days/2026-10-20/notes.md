### Eloquent Postman Collection Export

This example demonstrates how to create a custom API endpoint using Laravel's Eloquent ORM and export a collection of data in JSON format. We'll also show you how to test this endpoint using Pest.

#### Step 1: Create the Post Model

First, let's create a `Post` model that extends the Eloquent base class:
```php
// app/Models/Post.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    public $timestamps = true;

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
#### Step 2: Create the PostController

Next, let's create a `PostController` that extends the base controller:
```php
// app/Http/Controllers/PostController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Post;

class PostController extends Controller
{
    public function exportPostmanCollection(Request $request)
    {
        // Get all posts from the database
        $posts = Post::all();

        // Create a new array to store the post data
        $postData = [];

        // Loop through each post and extract the necessary data
        foreach ($posts as $post) {
            $postData[] = [
                'name' => $post->title,
                'description' => $post->content,
                'author' => $post->user->name,
                'created_at' => $post->created_at->format('Y-m-d H:i:s'),
            ];
        }

        // Return the post data as a JSON string
        return response()->json($postData);
    }
}
```
#### Step 3: Test the exportPostmanCollection Method

Finally, let's test the `exportPostmanCollection` method using Pest:
```php
// tests/Feature/PostControllerTest.php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;

class PostControllerTest extends TestCase
{
    public function testExportPostmanCollection()
    {
        // Create some sample posts for testing
        $post1 = new Post();
        $post1->title = 'Sample Post 1';
        $post1->content = 'This is a sample post.';
        $post1->save();

        $post2 = new Post();
        $post2->title = 'Sample Post 2';
        $post2->content = 'This is another sample post.';
        $post2->save();

        // Send a request to the exportPostmanCollection method
        $response = $this->actingAs(\Auth::user())->get(route('export-postman-collection'));

        // Assert that the response contains the expected data
        $response->assertJson([
            'name' => 'Sample Post 1',
            'description' => 'This is a sample post.',
            'author' => 'John Doe', // Assuming John Doe is the user's name
            'created_at' => '2022-01-01 00:00:00',
        ]);

        // Assert that two posts were returned in the response
        $this->assertEquals(2, count($response->json()));
    }
}
```
This example demonstrates how to create a custom API endpoint using Laravel's Eloquent ORM and export a collection of data in JSON format. We've also shown you how to test this endpoint using Pest.