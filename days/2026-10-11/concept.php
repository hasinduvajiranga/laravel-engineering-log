// App/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{
    use HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function userVersions()
    {
        return $this->hasMany(UserVersion::class);
    }
}

// App/Models/UserVersion.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserVersion extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'version_number',
        'created_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

// App/Http/Livewire/UserVersionsController.php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\UserVersion;

class UserVersionsController extends Component
{
    public $userId;
    public $versionNumber;

    public function updatedVersionNumber()
    {
        // Update the version number and create a new user version
        $userVersion = new UserVersion();
        $userVersion->user_id = $this->userId;
        $userVersion->version_number = $this->versionNumber;
        $userVersion->save();

        // Return the list of user versions for the specified user
        return response()->json($userVersion->user->userVersions, 200);
    }

    public function render()
    {
        return view('livewire.user-versions');
    }
}