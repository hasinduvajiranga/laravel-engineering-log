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
        $response->assertViewIs('admin.users.index');
        $response->assertViewHas('users');
    }

    public function test_store_valid_request_creates_user()
    {
        $request = UserRequest::make([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $this->post(route('admin.users.store'), $request)->assertRedirect(route('admin.users.index'));
        $this->assertCount(1, User::all());
    }

    public function test_store_invalid_request_returns_error()
    {
        $response = $this->post(route('admin.users.store'), [
            'name' => '',
            'email' => '',
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHasErrors();
    }

    public function test_show_returns_view_with_user_details()
    {
        $user = User::factory()->create();

        $response = $this->get($user->id);
        $response->assertViewIs('admin.users.show');
        $response->assertViewHas('user', $user);
    }
}