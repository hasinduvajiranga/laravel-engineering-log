// app/Observers/UserObserver.php

namespace App\Observers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserObserver
{
    public function created(User $user)
    {
        // Log the user creation event
        \Log::info('User created: ' . $user->name);

        // Send a notification to the user's email address after creating a
an account
        $user->notify(new RegistrationCompleteNotification($user));
    }

    public function updated(User $user)
    {
        // Log the user update event
        \Log::info('User updated');

        // Trigger the Save Changes event on any listeners registered for t
this model
        $user->saveChanges();
    }
}