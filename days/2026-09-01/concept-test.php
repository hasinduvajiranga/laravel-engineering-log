// tests/Models/UserTest.php

namespace Tests\Models;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    public function testCreatingUserTriggersEvent()
    {
        $user = new User(['name' => 'John Doe', 'email' => 'john@example.com']);

        $this->assertNull(User::where('id', 1)->first());

        event->assertFirst(CreatedUserEvent::class, function ($event) {
            return $event->user === $user;
        });

        $this->expectationFailure(function () {
            expect($user->fresh()->created_at)->toBeNow();
        });
    }

    public function testUpdatingUserTriggersEvent()
    {
        $user = new User(['name' => 'John Doe', 'email' => 'john@example.com']);

        $user->save();

        $this->assertNotNull(User::where('id', 1)->first());

        event->assertFirst(UpdatedUserEvent::class, function ($event) {
            return $event->user === $user;
        });

        $user->fill(['name' => 'Jane Doe', 'email' => 'jane@example.com'])->save();

        $this->expectationFailure(function () {
            expect($user->fresh()->updated_at)->toBeNow();
        });
    }
}