# Class-Based Blade Components

In Laravel, we can create reusable and modular code using class-based components. These components allow us to separate the presentation layer from our application's business logic.

Here is an example of how we can refactor our existing `PostController` to use class-based components:

## Creating a Post Component
```php
// File: app/Http/Components/PostComponent.blade.php

<div>
    <h1>{{ $post->title }}</h1>
    <p>{{ $post->content }}</p>
</div>
```

## Creating an Edit Post Component
```php
// File: app/Http/Components/PostEditComponent.blade.php

<form method="POST" action="{{ route('posts.update', ['post' => $post]) }}">
    @csrf
    <label for="title">Title:</label>
    <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}">
    <label for="content">Content:</label>
    <textarea id="content" name="content">{{ old('content', $post->content) }}</textarea>
    <button type="submit">Update Post</button>
</form>
```

## Creating a Post Component
```php
// File: app/Http/Components/PostComponent.php

namespace App\Http\Components;

use Illuminate\View\Component;
use App\Models\Post;

class PostComponent extends Component
{
    public $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function render()
    {
        return view('components.post');
    }
}
```

We can then use our `PostComponent` in our views:
```php
// File: resources/views/posts/index.blade.php

@foreach($posts as $post)
    <div>
        {{ $this->component(new PostComponent($post)) }}
    </div>
@endforeach
```

By using class-based components, we can keep our code organized and easy to maintain. We can also reuse this component in other parts of our application.

## Testing Class-Based Components

To test our `PostComponent`, we can use a testing library such as Pest or PHPUnit. Here is an example of how we can test our component:

```php
// File: tests/Feature/PostComponentTest.php

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostComponentTest extends TestCase
{
    use RefreshDatabase;

    public function testRender()
    {
        $post = Post::create(['title' => 'New Post Title', 'content' => 'New post content']);

        $response = $this->get('/posts');
        $response->assertViewIs('components.post');

        $this->assertEquals($post->id, (int) Request::instance()->input('post.id'));
    }
}
```

By using class-based components, we can create a more modular and maintainable codebase. This allows us to reuse our components in different parts of the application, making it easier to manage complexity.