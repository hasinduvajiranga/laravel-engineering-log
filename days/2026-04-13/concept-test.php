// tests/ObserverTest.php

namespace Tests\Feature;

use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Laravel\Dusk\Browser;
use Pest\LaravelTestCase;

class ObserverTest extends LaravelDuskTestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        UserObserver::observe(User::class);
    }

    public function testUserCreatedEvent()
    {
        // Create a new user and verify it's observed by the UserObserver
        $user = factory(User::class)->create();

        // Verify that the 'created' event was triggered for this model
        self::assertTrue(\Log::recorded('User created: ' . $user->name));
    }

    public function testUserUpdatedEvent()
    {
        // Create a new user and update it
        $user = factory(User::class)->create();
        $user->update(['email' => 'new@example.com']);

        // Verify that the 'updated' event was triggered for this model
        self::assertTrue(\Log::recorded('User updated'));
    }

    public function testSaveChangesEvent()
    {
        // Create a new user and update it
        $user = factory(User::class)->create();
        $user->update(['email' => 'new@example.com']);

        // Verify that the Save Changes event was triggered for this model
        self::assertTrue($user->saveChanges());
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        UserObserver::observe(User::class);
    }
}