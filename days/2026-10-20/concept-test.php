<?php

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