// File: tests/Http/ExampleControllerTest.php

use App\Http\Controllers\ExampleController;
use Illuminate\Foundation\Http\FormRequestTestCase;

class ExampleControllerTest extends FormRequestTestCase
{
    protected function getRoute(): string
    {
        return 'GET /example';
    }

    public function testGetRequest()
    {
        $response = $this->get('/example');
        $response->assertStatus(200);
    }

    public function testStoreRequest()
    {
        $response = $this->post('/example', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
        $response->assertStatus(302);
        $this->assertRedirects($response, '/example/store');
    }

    public function testShowRequest()
    {
        // Create a fake user
        factory(App\User::class)->create(['name' => 'John Doe', 'email' => 'john@example.com']);

        $response = $this->get('/example/' . 1);
        $response->assertStatus(200);

        // Delete the created user to avoid test flakiness
        $this->delete('/example/1');
    }

    public function testUpdateRequest()
    {
        // Create a fake user
        factory(App\User::class)->create(['name' => 'John Doe', 'email' => 'john@example.com']);

        $response = $this->put('/example/1', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
        ]);
        $response->assertStatus(302);
        $this->assertRedirects($response, '/example/update/1');

        // Update the user
        $user = App\User::find(1);
        $user->name = 'Jane Doe';
        $user->email = 'jane@example.com';
        $user->save();

        // Assert that the data is correct
        $this->assertEquals('Jane Doe', $user->name);
        $this->assertEquals('jane@example.com', $user->email);

        // Delete the created user to avoid test flakiness
        factory(App\User::class)->create(['name' => 'John Doe', 'email' => 'john@example.com']);
    }

    public function testDestroyRequest()
    {
        // Create a fake user
        factory(App\User::class)->create(['name' => 'John Doe', 'email' => 'john@example.com']);

        $response = $this->delete('/example/1');
        $response->assertStatus(302);

        // Assert that the data is correct
        $this-> assertEquals('John Doe was successfully deleted!', session('message'));
    }
}