// File: tests/Unit Tests/UserTest.php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\View;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    public function testAdminUsers()
    {
        // Create some admin users
        $adminUser = new User();
        $adminUser->name = 'Admin User';
        $adminUser->email = 'admin@example.com';
        $adminUser->role = 'admin';
        $adminUser->save();

        $user = new User();
        $user->name = 'Normal User';
        $user->email = 'normal@example.com';
        $user->save();

        // Use the global scope to filter admin users
        $users = User::adminUsers()->get();

        $this->assertCount(1, $users);
        $this->assertEquals('Admin User', $users[0]->name);

        // Use another global scope to filter department-specific users
        $departmentId = 1;
        $departmentUsers = User::departmentUsers($departmentId)->get();

        $this->assertCount(2, $departmentUsers);
        $this->assertTrue($departmentUsers[0]->name === 'Department User');
User');
    }

    public function testDepartmentUsers()
    {
        // Create some department users
        $user1 = new User();
        $user1->name = 'Department User 1';
        $user1->email = 'department1@example.com';
        $user1->save();

        $user2 = new User();
        $user2->name = 'Department User 2';
        $user2->email = 'department2@example.com';
        $user2->save();

        // Use the global scope to filter department-specific users
        $departmentId = 1;
        $users = User::departmentUsers($departmentId)->get();

        $this->assertCount(1, $users);
        $this->assertEquals('Department User 1', $users[0]->name);

        // Test that non-existent department returns no results
        $nonExistentDepartment = User::departmentUsers(999)->get();
        $this->assertCount(0, $nonExistentDepartment);
    }
}