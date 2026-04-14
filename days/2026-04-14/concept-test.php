// EventSourcing/TestCase.php

namespace App\EventStore\Tests;

use App\Events\UserUpdated;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Facades\Auth;
use App\EventStore\EventStore;
use App\EventStore\Repository\UserRepository;

class UserRepositoryTest extends TestCase
{
    protected $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = new UserRepository();
        $this->eventStore = new EventStore($this->repository);
    }

    public function test_store_user_update()
    {
        $userUpdate = new UserUpdated(1, ['name' => 'John Doe', 'email' => 
'john@example.com']);

        $response = $this->eventStore->storeUserUpdate($userUpdate);

        $user = User::find($response);

        $this->assertNotNull($user);
    }
}

class EventStoreTest extends TestCase
{
    protected $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = new UserRepository();
        $this->eventStore = new EventStore($this->repository);
    }

    public function test_get_events_by_aggregate_id()
    {
        $userUpdate1 = new UserUpdated(1, ['name' => 'John Doe', 'email' =>
=> 'john@example.com']);
        $userUpdate2 = new UserUpdated(1, ['name' => 'Jane Doe', 'email' =>
=> 'jane@example.com']);

        $this->eventStore->storeUserUpdate($userUpdate1);
        $this->eventStore->storeUserUpdate($userUpdate2);

        $events = $this->eventStore->getEventsByAggregateId(1);

        $this->assertCount(2, $events);
    }
}