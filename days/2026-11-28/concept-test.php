// File: tests/Feature/PostControllerTest.php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;

class PostControllerTest extends TestCase
{
    public function test_index()
    {
        $response = $this->get('/posts');
        $response->assertStatus(200);
        $response->assertHeader('X-Total-Count', 50);
    }

    public function test_store()
    {
        $response = $this->post('/posts', ['title' => 'Test Post', 'content' => 'This is a test post']);
        $response->assertStatus(201);
        $this->assertCount(1, Post::all());
    }

    // You can add more tests here to simulate load testing
}