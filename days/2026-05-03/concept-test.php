// tests/Feature/UserControllerTest.php

namespace Tests\Feature;

use App\Http\Controllers\UserController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker, DatabaseMigrations, WithoutMiddleware;

    public function test_index()
    {
        // Test the index method to ensure Eager Loading is working correct
correctly
        $this->actingAs($this->user());
        
        $response = $this->get(route('users.index'));
        
        $response->assertViewIs('users.index');
        $response->assertViewHas('users');
    }
    
    public function test_show()
    {
        // Test the show method to ensure Relationship Caching is working c
correctly
        $user = User::factory()->create();
        
        $response = $this->get(route('user.show', ['id' => $user->id]));
        
        $response->assertViewIs('user.show');
        $response->assertViewHas('posts');
    }
}