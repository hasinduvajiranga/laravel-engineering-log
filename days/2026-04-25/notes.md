# Soft Deletes and Restoration

Soft deletes are a technique used to mark records in the database as delete
deleted without actually removing them. This can be useful for various purp
purposes, such as auditing or reverting changes.

In Laravel, soft deletes are achieved using the `SoftDeletes` trait provide
provided by Eloquent. When you use this trait on a model, it automatically 
adds two columns to the table: `deleted_at` and `id`. The `deleted_at` colu
column stores the timestamp when the record was deleted.

Here's an example of how you can implement soft deletes in your Laravel app
application:

1.  **Use the SoftDeletes trait**: In your model file, use the `SoftDeletes
`SoftDeletes` trait to enable soft deletes.
2.  **Define a scope for is_deleted records**: You can define a scope on yo
your model that returns only the deleted records. This can be useful when y
you need to display or filter out deleted records in your application.

```php
// models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;

    protected $hidden = [
        'deleted_at',
    ];

    public function scopeIsDeleted($query)
    {
        return $query->where('deleted_at', '<>', null);
    }

    public function scopeRestore($query)
    {
        return $query->update(['deleted_at' => null]);
    }
}
```

3.  **Create a service class for user operations**: You can create a servic
service class to handle all the business logic related to users, such as cr
creating and restoring deleted users.

```php
// app/Services/UserService.php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function create($data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return $user;
    }

    public function restoreUser(User $user)
    {
        $user->restore();
        return $user;
    }
}
```

4.  **Write unit tests for the service class**: You can write unit tests to
to ensure that your service class is working correctly.

```php
// tests/Unit/Services/UserServiceTest.php

namespace Tests\Unit\Services;

use App\Services\UserService;
use App\Models\User;
use Laravel\Sanctum\LaravelUserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class UserServiceTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testCreateUser()
    {
        $service = new UserService();
        $user = $service->create([
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'password' => $this->faker->password(),
        ]);

        $this->assertDatabaseHas('users', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => bcrypt($user->password),
        ]);
    }

    public function testRestoreUser()
    {
        $service = new UserService();
        $user = $service->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'test_password',
        ]);

        $user->delete();

        $this->assertDatabaseMissing('users', [
            'name' => $user->name,
            'email' => $user->email,
        ]);

        $restoredUser = $service->restoreUser($user);

        $this->assertInstanceOf(User::class, $restoredUser);
        $this->assertEquals($user->name, $restoredUser->name);
        $this->assertEquals($user->email, $restoredUser->email);
    }
}
```

By following these steps and implementing soft deletes in your Laravel appl
application, you can easily manage deleted records and provide a better use
user experience for your users.