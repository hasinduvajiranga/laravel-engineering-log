// File: tests/Models/UserTest.php

namespace Tests\Models;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Pest\Laravel\Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        // Create some test data
        DB::table('users')->insert([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'geometry' => ST_GeomFromText('POINT(12.345 56.789)'),
        ]);

        DB::table('users')->insert([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'geometry' => ST_GeomFromText('POINT(10.012 54.321)'),
        ]);
    }

    public function testByLocation()
    {
        $user = new User();
        $users = $user->byLocation(37.7749, -122.4194);

        $this->assertCount(1, $users);
        $this->assertEquals(ST_GeomFromText('POINT(-122.4194 37.7749)'), $users[0]->geometry);
    }
}