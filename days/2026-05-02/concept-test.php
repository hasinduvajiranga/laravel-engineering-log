// File: tests/Http/ControllerTest.php

namespace Tests\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Facades\Blade;
use App\Http\Controllers\AdminController;
use App\Models\UserModel;

class AdminControllerTest extends TestCase
{
    use DatabaseMigrations;

    protected $controller = new AdminController();

    public function testIndex()
    {
        // Test that the index method returns a successful response with 20
200 status code
        $response = $this->get(route('admin.users.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.users.index');
    }

    public function testCreate()
    {
        // Test that the create method fetches users from cache and returns
returns a successful response with 200 status code
        $this->get(route('admin.users.create'))
            ->assertStatus(200)
            ->assertViewIs('admin.users.create')
            ->assertSessionHas('users');
    }

    public function testStore()
    {
        // Test that the store method creates a new user instance and persi
persists it to the database
        $request = new Request();
        $request->request->add([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
        ]);
        $response = $this->post(route('admin.users.store'), $request);
        $response->assertStatus(302);

        // Verify that the new user instance was created and persisted to t
the database
        $user = UserModel::where('name', 'John Doe')->first();
        $this->assertInstanceOf(UserModel::class, $user);
    }

    public function testEdit()
    {
        // Test that the edit method returns a successful response with 200
200 status code
        $user = new UserModel(['name' => 'John Doe']);
        $response = $this->get(route('admin.users.edit', $user));
        $response->assertStatus(200);
        $response->assertViewIs('admin.users.edit');
    }

    public function testUpdate()
    {
        // Test that the update method updates an existing user instance an
and persists it to the database
        $user = new UserModel(['name' => 'John Doe']);
        $request = new Request();
        $request->request->add([
            'name' => 'Jane Doe',
            'email' => 'jane.doe@example.com',
        ]);
        $response = $this->patch(route('admin.users.update', $user), $reque
$request);
        $response->assertStatus(302);

        // Verify that the existing user instance was updated and persisted
persisted to the database
        $updatedUser = UserModel::where('name', 'Jane Doe')->first();
        $this->assertEquals('Jane Doe', $updatedUser->name);
    }

    public function testDestroy()
    {
        // Test that the destroy method deletes a user instance from the da
database
        $user = new UserModel(['name' => 'John Doe']);
        $response = $this->delete(route('admin.users.destroy', $user));
        $response->assertStatus(302);

        // Verify that the deleted user instance was removed from the datab
database
        $deletedUser = UserModel::where('name', 'John Doe')->first();
        $this->cassertNull($deletedUser);
    }
}