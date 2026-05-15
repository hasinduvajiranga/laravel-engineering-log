// File: tests/Http/Controllers/UserControllerTest.php

namespace Tests\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_index()
    {
        // Mocking the cache to return data immediately
        $this->mockCache()->shouldReceive('has')->andReturn(true);
        $this->mockCache()->shouldReceive('get')->andReturn(['user1', 'user
'user2']);

        $response = $this->actingAs($this->user())
            ->get('/users');

        $response->assertStatus(200);
        $response->assertJson(['data' => ['user1', 'user2']]);
    }

    private function mockCache()
    {
        return Mockery::mock(\Illuminate\Support\Facades\Cache::class);
    }
}