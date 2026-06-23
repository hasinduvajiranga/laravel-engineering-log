# Controller Testing Patterns

When testing controllers in Laravel, it's essential to consider the controller's responsibilities and how they interact with your application's data. Here are some key patterns to keep in mind:

## 1. Mocking and Stubbing

In controller tests, you often need to mock or stub dependencies like repositories, services, or other controllers. This allows you to isolate the controller's behavior and test its logic independently.

### Example:
```php
use App\Repositories\UserRepository;

class UserControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = app(UserRepository::class);
        // Stub or mock any dependencies required by the controller here
    }

    public function test_index_returns_all_users()
    {
        return $this->get('/users')
            ->assertStatus(200)
            ->assertJsonCount(count($this->userRepository->all()));
    }
}
```

## 2. Request and Response Objects

When testing controllers, you need to use the correct request and response objects to simulate incoming requests and outgoing responses.

### Example:
```php
use Illuminate\Http\Request;

class UserControllerTest extends TestCase
{
    public function test_index_returns_all_users()
    {
        $request = new Request(['method' => 'GET']);
        return $this->get('/users', $request)
            ->assertStatus(200)
            ->assertJsonCount(count(User::all()));
    }
}
```

## 3. Model and Database Interactions

When testing controllers, you need to ensure that your models and database are properly updated and reflected in the test output.

### Example:
```php
use App\Models\User;

class UserControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        User::factory()->create(); // Create a user for testing purposes
    }

    public function test_show_user_returns_user_details()
    {
        return $this->get('/users/1')
            ->assertStatus(200)
            ->assertJson(['id' => 1, 'name' => 'John Doe']);
    }
}
```

## 4. Error Handling and Edge Cases

When testing controllers, it's crucial to cover error handling and edge cases to ensure that your application behaves as expected.

### Example:
```php
use App\Http\Controllers\UserController;

class UserControllerTest extends TestCase
{
    public function test_show_invalid_user_returns_404()
    {
        return $this->get('/users/99999')
            ->assertStatus(404);
    }
}
```

By following these patterns and considering the specific needs of your application, you can write more comprehensive and effective controller tests.