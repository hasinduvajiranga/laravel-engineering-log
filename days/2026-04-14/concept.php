// EventSourcing/Event.php

namespace App\Events;

use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokensTrait;
use Ramsey\Uuid\Uuid;

class UserUpdated implements ShouldBePublished
{
    use HasApiTokensTrait;

    public $userId;
    public $userData;

    public function __construct($userId, $userData)
    {
        $this->userId = $userId;
        $this->userData = $userData;
    }

    public function getTopic()
    {
        return 'user.updated';
    }

    public function getAggregateId()
    {
        return $this->userId;
    }
}

// EventSourcing/Repository.php

namespace App\EventStore\Repository;

use App\Events\UserUpdated;
use Illuminate\Support\Facades\Cache;

class UserRepository
{
    private $events = [];

    public function store(UserUpdated $event)
    {
        $this->events[] = $event;
        return $event->getAggregateId();
    }

    public function getEventsBy aggregateId($aggregateId)
    {
        $events = Cache::rememberForever(function () use ($aggregateId) {
            return $this->events()->where('aggregate_id', $aggregateId)->ge
$aggregateId)->get();
        }, 3600);

        return $events;
    }
}

// EventSourcing/Aggregate.php

namespace App\EventStore\Aggregates;

use App\Events\UserUpdated;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $events = [];

    public function getEvents()
    {
        return $this->events;
    }

    public function append($event)
    {
        $this->events[] = $event;
    }
}

// EventSourcing\EventStore.php

namespace App\EventStore;

use App\Events\UserUpdated;
use Illuminate\Support\Facades\DB;

class EventStore
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function storeUserUpdate(UserUpdated $event)
    {
        $aggregateId = $this->repository->store($event);
        $user = User::find($aggregateId);

        if (!$user) {
            $user = new User();
            $user->id = $aggregateId;
        }

        $user->append($event);

        DB::table('users')->where('id', $aggregateId)->update(['updated_at'
$aggregateId)->update(['updated_at' => date('Y-m-d H:i:s')]);

        return $user;
    }
}