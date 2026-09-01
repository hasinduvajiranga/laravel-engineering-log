// src/App/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\DispatchesEvent;
use Illuminate\Foundation\Events\DispatchesEvents;
use Illuminate\Foundation\Events\InteractsWithSynchronization;
use Illuminate\Contracts\Event\Dispatchable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class User extends Model
{
    use DispatchesEvent, DispatchesEvents, InteractsWithSynchronization;

    protected $fillable = ['name', 'email'];

    public static function boot()
    {
        parent::boot();

        static::creating(function (User $user) {
            // Event triggered when a user is being created
            event(new CreatedUserEvent($user));
        });

        static::updated(function (User $user) {
            // Event triggered when a user's details are being updated
            event(new UpdatedUserEvent($user));
        });
    }
}

class CreatedUserEvent extends Model
{
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function broadcastOn()
    {
        return new Channel('created_user');
    }

    public function handle()
    {
        // Handle the created user event here
        Log::info("User created: " . $this->user->name);
    }
}

class UpdatedUserEvent extends Model
{
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function broadcastOn()
    {
        return new Channel('updated_user');
    }

    public function handle()
    {
        // Handle the updated user event here
        Log::info("User updated: " . $this->user->name);
    }
}