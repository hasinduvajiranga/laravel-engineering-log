// File: tests/Http/Controllers/EloquentApiControllerTest.php

namespace Tests\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\WithApplicationException;
use Tests\TestCase;
use App\Models\MyModel; // Replace with your actual model name

class EloquentApiControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker, WithoutMiddleware, WithApplicationException;

    public function testIndexResponseHasLastModifiedHeader()
    {
        MyModel::factory(10)->create();
        $response = $this->get('/api/eloquent');
        $response->assertStatus(200);
        $response->assertHeader('Last-Modified', \Carbon\Carbon::now()->toRfc3328());
    }

    public function testShowResponseHasLastModifiedHeader()
    {
        MyModel::factory()->create();
        $response = $this->get('/api/eloquent/1');
        $response->assertStatus(200);
        $response->assertHeader('Last-Modified', \Carbon\Carbon::now()->toRfc3328());
    }

    public function testStoreResponseHasLastModifiedHeader()
    {
        $response = $this->post('/api/eloquent', ['name' => 'Test Model']);
        $response->assertStatus(201);
        $response->assertHeader('Last-Modified', \Carbon\Carbon::now()->toRfc3328());
    }

    public function testUpdateResponseHasLastModifiedHeader()
    {
        MyModel::factory()->create();
        $response = $this->patch('/api/eloquent/1', ['name' => 'Updated Test Model']);
        $response->assertStatus(200);
        $response->assertHeader('Last-Modified', \Carbon\Carbon::now()->toRfc3328());
    }

    public function testDestroyResponseHasLastModifiedHeader()
    {
        MyModel::factory()->create();
        $response = $this->delete('/api/eloquent/1');
        $response->assertStatus(204);
        $response->assertHeader('Last-Modified', \Carbon\Carbon::now()->toRfc3328());
    }

    public function testIndexResponseHasCorrectLastModifiedTime()
    {
        MyModel::factory(10)->create();
        $response = $this->get('/api/eloquent');
        $lastModified = $response->headers->get('Last-Modified');
        \Carbon\Carbon::assertIsSameInstance($lastModified, \Carbon\Carbon::now());
    }

    public function testShowResponseHasCorrectLastModifiedTime()
    {
        MyModel::factory()->create();
        $response = $this->get('/api/eloquent/1');
        $lastModified = $response->headers->get('Last-Modified');
        \Carbon\Carbon::assertIsSameInstance($lastModified, \Carbon\Carbon::now());
    }
}