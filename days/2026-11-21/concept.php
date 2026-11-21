// File: app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function metrics()
    {
        return $this->hasMany(Metric::class, 'user_id');
    }
}

// File: app/Metrics.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Datadog\DatadogLaravel\Metric;

class Metric extends Model
{
    protected $fillable = [
        'name',
        'value',
        'unit',
        'tags',
    ];

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}