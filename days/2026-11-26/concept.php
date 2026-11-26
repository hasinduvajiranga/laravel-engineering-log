// File: app/Models/Sla.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Sla extends Model
{
    protected $fillable = ['api_id', 'threshold', 'unit'];

    public function api()
    {
        return $this->belongsTo(Api::class);
    }
}

// File: app/Models/Api.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Api extends Model
{
    protected $fillable = ['id', 'name', 'status'];

    public function slas()
    {
        return $this->hasMany(Sla::class);
    }

    public function getAverageResponseTimeAttribute()
    {
        // Calculate average response time for the API
        $responseTimes = $this->slas()->pluck('response_time');
        if ($responseTimes->count() > 0) {
            return Carbon::average($responseTimes);
        } else {
            return null;
        }
    }

    public function getAverageLatencyAttribute()
    {
        // Calculate average latency for the API
        $latencies = $this->slas()->pluck('latency');
        if ($latencies->count() > 0) {
            return Carbon::average($latencies);
        } else {
            return null;
        }
    }
}

// File: app/Models/Sla.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Sla extends Model
{
    protected $fillable = ['id', 'api_id', 'threshold', 'unit'];

    public function api()
    {
        return $this->belongsTo(Api::class);
    }

    public function getResponseTimeAttribute($value)
    {
        // Convert response time to a Carbon object for easy comparison
        return Carbon::parse($value);
    }
}