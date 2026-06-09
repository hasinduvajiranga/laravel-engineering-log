# Single Action Controllers

A Single Action Controller is a design pattern used in Laravel where each controller has only one main action. This approach promotes simplicity, readability, and maintainability of the codebase.

## Benefits

- **Simplified Code**: Each controller has a single responsibility, making it easier to read and understand.
- **Improved Testability**: With fewer actions, there's less complexity for testing, making unit tests more manageable.
- **Better Error Handling**: Single action controllers can handle errors in a more contained manner.

## Design

In a Single Action Controller, each action (e.g., `index`, `store`, `show`) serves a single purpose. This separation of concerns makes the codebase easier to maintain and extend.

```php
// app/Http/Controllers/Admin/UserController.php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle(Request $request)
    {
        // Process the request and return a response
        switch ($request->action) {
            case 'index':
                return $this->handleIndex($request);
            case 'store':
                return $this->handleStore($request);
            case 'show':
                return $this->handleShow($request);
            default:
                abort(404);
        }
    }

    /**
     * Handle the index action.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    private function handleIndex(Request $request)
    {
        // Return a response for the index action
    }

    /**
     * Handle the store action.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    private function handleStore(Request $request)
    {
        // Store data and return a response
    }

    /**
     * Handle the show action.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    private function handleShow(Request $request)
    {
        // Return a response for the show action
    }
}
```
This design allows each action to be handled by a separate method, making it easier to test and maintain.

```php
// tests/Feature/Admin/UserControllerTest.php

namespace Tests\Feature\Admin;

use App\Http\Controllers\Admin\UserController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\TestCase;
use Tests\Models\User;
use App\Http\Requests\UserRequest;

class UserControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setup()
    {
        parent::setup();
        $this->actingAs(User::factory()->create());
    }

    public function test_index_returns_view_with_users_list()
    {
        $response = $this->get(route('admin.users.index'));
        // Assert the response
    }
}
```
In summary, Single Action Controllers promote simplicity, readability, and maintainability by limiting each controller to a single main action.