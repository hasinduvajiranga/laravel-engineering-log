use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UsersTableSeederTest extends TestCase
{
    use DatabaseMigrations;

    public function test_seeding_users_table()
    {
        $this->artisan('seed:users');

        // Verify that the users table has been seeded correctly
        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com'
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com'
        ]);
    }
}