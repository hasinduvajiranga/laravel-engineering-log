// File: app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DateTime;

class User extends Model
{
    protected $fillable = ['name', 'email', 'password'];

    public function backups()
    {
        return $this->hasMany(Backup::class);
    }
}

// File: app/Models/Backup.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Backup extends Model
{
    protected $fillable = ['user_id', 'created_at'];

    public function getUser()
    {
        return $this->belongsTo(User::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }
}