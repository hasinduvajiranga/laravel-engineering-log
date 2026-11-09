use Tests\TestCase;
use App\Models\User;

class EloquentApiIdempotencyTest extends TestCase
{
    public function testCreateIdempotentUser()
    {
        // Mock the request input data
        $inputData = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
        ];

        // Create a new user with the same email
        $existingUser = User::where('email', $inputData['email'])->first();
        if (!$existingUser) {
            factory(User::class, 1)->create($inputData);
            $existingUser = User::where('email', $inputData['email'])->first();
        }

        // Test creating a new user with the same email
        $response = $this->actingAs($existingUser)
            ->post(route('users.store'), $inputData);

        // Verify that the response status is 200 and no additional data was added
        $response->assertOk()
                 ->assertJson(['id', 'name', 'email'])
                 ->assertJsonMissing(['created_at', 'updated_at']);

        // Test updating an existing user with the same email
        $inputData['name'] = 'Jane Doe';

        $response = $this->actingAs($existingUser)
            ->patch(route('users.update'), $inputData);

        // Verify that the response status is 200 and no additional data was added
        $response->assertOk()
                 ->assertJson(['id', 'name', 'email'])
                 ->assertJsonMissing(['created_at', 'updated_at']);
    }

    public function testUpdateIdempotentUser()
    {
        // Mock the request input data
        $inputData = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
        ];

        // Create a new user with the same email
        factory(User::class, 1)->create($inputData);

        // Test updating an existing user with the same email
        $response = $this->actingAs(factory(User::class)->create(['email' => $inputData['email']]))
            ->patch(route('users.update'), $inputData);

        // Verify that the response status is 200 and no additional data was added
        $response->assertOk()
                 ->assertJson(['id', 'name', 'email'])
                 ->assertJsonMissing(['created_at', 'updated_at']);
    }

    public function testUpdateIdempotentUserFailure()
    {
        // Mock the request input data
        $inputData = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
        ];

        // Create a new user with the same email
        factory(User::class, 1)->create($inputData);

        // Test updating an existing user with the same email (should fail)
        $response = $this->actingAs(factory(User::class)->create(['email' => $inputData['email']]))
            ->patch(route('users.update'), ['id' => factory(User::class)->create(['email' => $inputData['email']])->id, 'name' => 'Invalid Name']);

        // Verify that the response status is 422 and error message is present
        $response->assertStatus(422)
                 ->assertJson(['errors' => [
                     ['name', 'The name field is required.'],
                     ['name', 'The name must be at least 2 characters long.'],
                 ]]);
    }
}