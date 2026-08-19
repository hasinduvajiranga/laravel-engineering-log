// File: tests/Model/UserTest.php

namespace Tests\Models;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    public function testRawWhere()
    {
        DB::statement('CREATE TABLE users (id INT, name VARCHAR(255), email VARCHAR(255))');
        \DB::table('users')->insert([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com'
        ]);

        $user = User::whereRaw('name', 'John Doe')->first();

        $this->assertEquals('John Doe', $user->name);

        DB::statement('DROP TABLE users');
    }

    public function testRawLike()
    {
        DB::statement('CREATE TABLE users (id INT, name VARCHAR(255), email VARCHAR(255))');
        \DB::table('users')->insert([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com'
        ]);

        $user = User::whereRaw('email', '%' . 'example' . '%')->first();

        $this->assertEquals('john.doe@example.com', $user->email);

        DB::statement('DROP TABLE users');
    }
}