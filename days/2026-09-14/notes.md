### Eloquent Simple Pagination

Eloquent provides a convenient way to implement pagination using its `paginate` method. However, the default implementation uses the `Illuminate\Pagination\LengthAwarePaginator` class, which requires manual manipulation of pagination variables.

In this example, we'll define a custom scope on the `User` model to simplify pagination.

#### Step 1: Define the Custom Scope

Create a new file in `app/Models/User.php` and add the following code:
```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination Paginate;

class User extends Model
{
    protected $fillable = [
        'name', 
        'email'
    ];

    public function scopePaginated($query, $perPage)
    {
        return $query->paginate($perPage);
    }
}
```
This defines a new scope called `paginated` that takes two parameters: `$query` and `$perPage`. The scope uses the `paginate` method to create a paginated instance of the query.

#### Step 2: Use the Custom Scope

In our controller, we can now use this custom scope to fetch paginated results:
```php
// Controllers/UserController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::scopePaginated(10, $request->input('page', 1));

        return view('users.index', compact('users'));
    }
}
```
#### Step 3: Display Pagination Links

In our Blade template, we can display pagination links using the `links` method:
```php
// Resources/views/users/index.blade.php
<x-layout>
    <h1>Users</h1>

    <ul>
        @foreach($users as $user)
            <li>{{ $user->name }} ({{ $user->email }})</li>
        @endforeach
    </ul>

    {{-- Pagination links --}}
    {{ $users->links() }}
</x-layout>
```
This allows us to easily paginate our results and provide links for users to navigate between pages.

#### Testing

We can test this custom scope using the `tests/Model/UserTest.php` file:
```php
// tests/Model/UserTest.php
namespace Tests\Models;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    public function testUserPaginate()
    {
        factory(User::class, 10)->create();

        $users = User::scopePaginated(5, 1);

        $this->assertCount(10, $users);
        $this->assertEquals(10, $users->total());
    }
}
```
This test creates a batch of 10 users and verifies that the paginated results contain all 10 items.