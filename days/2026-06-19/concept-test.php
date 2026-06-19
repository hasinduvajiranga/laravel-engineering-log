// tests/Http/ResourceControllerTest.php

namespace Tests\Http\Controllers;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Resource;

class ResourceControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function testIndex()
    {
        $response = $this->get(route('resources.index'));

        $response->assertViewIs('resources.index');
        $response->assertStatus(200);
    }

    public function testStore()
    {
        $data = [
            'name' => 'Test Resource',
            'description' => 'This is a test resource',
        ];

        $this->actingAs($this->user());
        $response = $this->post(route('resources.store'), $data);

        $response->assertStatus(302);
        $this-> ExpectInDatabase('resources', [
            'name' => $data['name'],
            'description' => $data['description'],
        ]);
    }

    public function testShow(Resource $resource)
    {
        $resource->save();

        $response = $this->get(route('resources.show', ['id' => $resource->id]));

        $response->assertViewIs('resources.show');
        $response->assertStatus(200);
    }

    public function testEdit()
    {
        $resource = Resource::factory()->create();

        $response = $this->actingAs($this->user())
            ->get(route('resources.edit', ['id' => $resource->id]));

        $response->assertViewIs('resources.edit');
        $response->assertStatus(200);
    }

    public function testUpdate()
    {
        $resource = Resource::factory()->create();

        $data = [
            'name' => 'Updated Test Resource',
            'description' => 'This is an updated test resource',
        ];

        $this->actingAs($this->user())
            ->patch(route('resources.update', ['id' => $resource->id]), $data);

        $response->assertStatus(302);
        $this-> ExpectInDatabase('resources', [
            'name' => $data['name'],
            'description' => $data['description'],
        ]);
    }

    public function testDestroy()
    {
        $resource = Resource::factory()->create();

        $this->actingAs($this->user())
            ->delete(route('resources.destroy', ['id' => $resource->id]));

        $response->assertStatus(302);
        $this-> ExpectInDatabase('resources', 'id', $resource->id);
    }
}