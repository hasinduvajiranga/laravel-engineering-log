// App/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\EventListener\HasListeners;

class User extends Model implements HasListeners
{
    use HasListeners;

    protected $events = [
        'created' => ['App\Listeners\CreatedUser'],
        'updated' => ['App\Listeners\UpdatedUser'],
        'deleted' => ['App\Listeners\DeletedUser']
    ];
}