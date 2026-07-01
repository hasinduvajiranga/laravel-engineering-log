// File: tests/Feature/PostControllerTest.php

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $response = $this->get('/posts');
        $response->assertViewIs('posts.index');
    }

    public function testCreate()
    {
        $response = $this->get('/posts/create');
        $response->assertViewIs('posts.create');
    }

    public function testStore()
    {
        $response = $this->post('/posts', [
            'title' => 'New Post Title',
            'content' => 'New post content',
        ]);

        $response->assertRedirect('/posts');
        $this->assertCount(1, Post::all());
    }

    public function testShow(Post $post)
    {
        $response = $this->get('/posts/' . $post->id);
        $response->assertViewIs('posts.show');
    }

    public function testEdit(Post $post)
    {
        $response = $this->get('/posts/' . $post->id . '/edit');
        $response->assertViewIs('posts.edit');
    }

    public function testUpdate()
    {
        $post = Post::create(['title' => 'New Post Title', 'content' => 'New post content']);
        $response = $this->patch('/posts/' . $post->id, [
            'title' => 'Updated Post Title',
            'content' => 'Updated post content',
        ]);

        $response->assertRedirect('/posts');
        $this-> expectPost($post->refresh)->toBe($response);
    }

    public function testDestroy(Post $post)
    {
        $response = $this->delete('/posts/' . $post->id);
        $response->assertRedirect('/posts');

        $this->assertCount(0, Post::all());
    }
}