// File: tests/Unit/Models/UserTest.php

namespace Tests\Unit\Models;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Pest\Laravel\PestTestCase;

class UserTest extends PestTestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

        DB::table('users')->truncate();
    }

    public function test_user_has_metrics()
    {
        $user = User::factory()->create();

        $metric = Metric::factory()->create(['user_id' => $user->id]);

        $this->assertCount(1, $user->metrics);
        $this->assertEquals($user->id, $metric->getUser()->id);
    }
}