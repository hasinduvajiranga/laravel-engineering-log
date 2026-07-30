// App/Listeners/CreatedUser.php

namespace App\Listeners;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreatedUser implements ShouldQueue
{
    public function handle(Model $user)
    {
        // Handle the created user event
        echo "User created successfully!\n";
        // Send notification or perform any other necessary actions
    }
}