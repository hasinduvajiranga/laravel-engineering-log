# Eloquent API Idempotency

Eloquent provides a way to ensure idempotency in the creation and update of resources using its built-in methods. In this section, we will discuss how to use these methods to create and update users with the same email.

## Eager Loading

To reduce database queries when creating or updating a user, we can eager load existing users with the same email. We use the `where` method to query for the existing user, and if it exists, we update or create a new user using the corresponding methods.

```php
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
    ];

    public function createIdempotentUser($inputData)
    {
        $existingUser = self::where('email', $inputData['email'])->first();

        if ($existingUser) {
            return $this->update($inputData);
        } else {
            return $this->create($inputData);
        }
    }

    public function update($data)
    {
        // Use Eloquent's built-in update method to ensure idempotency
        $updatedUser = $this->find($data['id'])->update($data);

        if (!$updatedUser) {
            throw new \Exception('Failed to update user');
        }

        return $updatedUser;
    }
}
```

## Test Cases

To test the creation and update of users with the same email, we can use the `actingAs` method in Laravel's testing facade. We will create a test class that tests different scenarios.

```php
class EloquentApiIdempotencyTest extends TestCase
{
    // ...

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

    // ...
}
```

## Idempotency in Update Method

Eloquent's built-in `update` method ensures idempotency by only updating the user if it exists. If the user does not exist, the method returns false.

```php
public function update($data)
{
    $updatedUser = $this->find($data['id'])->update($data);

    if (!$updatedUser) {
        throw new \Exception('Failed to update user');
    }

    return $updatedUser;
}
```

## Testing Idempotency in Update Method

To test the idempotency of the `update` method, we can use a similar approach as before. However, since the method returns false if the user does not exist, we need to modify the test case to handle this scenario.

```php
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
```

By following these steps, we can ensure that our Eloquent API is idempotent and provides a robust way to create and update resources with the same email.