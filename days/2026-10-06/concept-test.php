// File: tests/Unit Tests/UserTest.php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    public function test_user_can_create_backup()
    {
        $user = factory(User::class)->create();

        $backup = $user->backups()->create(['created_at' => now()]);

        $this->assertEquals($user->id, $backup->getUser()->id);
        $this->assertEquals(now(), Carbon::parse($backup->getCreatedAt())->format('Y-m-d H:i:s'));
    }

    public function test_user_can_get_backups()
    {
        $user = factory(User::class)->create();

        $backup1 = $user->backups()->create(['created_at' => now()]);
        $backup2 = $user->backups()->create(['created_at' => Carbon::now()->subHours(1)->format('Y-m-d H:i:s')]);

        $this->assertCount(2, $user->backups);
    }

    public function test_backup_has_correct_user_id()
    {
        $user = factory(User::class)->create();

        $backup = $user->backups()->create(['created_at' => now()]);

        $this->assertEquals($user->id, $backup->getUser()->id);
    }
}