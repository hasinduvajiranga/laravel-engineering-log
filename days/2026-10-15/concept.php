// models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email'];

    public function rateLimitedAPIRequests()
    {
        return $this->hasMany(RateLimitedAPIRequest::class);
    }
}

// models/RateLimitedAPIRequest.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RateLimitedAPIRequest extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'ip_address', 'request_time'];

    public function getUser()
    {
        return $this->belongsTo(User::class);
    }
}

// app/Http/Controllers/Api.php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RateLimitedAPIRequest;
use Laravel\Lumen\Http\Request as LumenRequest;

class Api extends Controller
{
    private $maxRequestsPerMinute = 10;
    private $timeWindowMinutes = 1;

    public function rateLimited($request)
    {
        $ipAddress = $request->server('REMOTE_ADDR');
        $currentTime = now()->toTimESTAMPString();

        // Check if the IP address has made requests in the last time window
        $requestsInTimeWindow = RateLimitedAPIRequest::where('user_id', auth()->id())
            ->whereBetween('request_time', [$currentTime - $this->timeWindowMinutes * 60, $currentTime])
            ->where('ip_address', $ipAddress)
            ->count();

        // Check if the number of requests in the time window exceeds the limit
        if ($requestsInTimeWindow >= $this->maxRequestsPerMinute) {
            throw new \Exception('Rate Limit Exceeded');
        }

        // Create a new rate limited API request and save it to the database
        RateLimitedAPIRequest::create([
            'user_id' => auth()->id(),
            'ip_address' => $ipAddress,
            'request_time' => $currentTime,
        ]);

        return response()->json(['message' => 'Rate limit request processed successfully'], 200);
    }

    // Other API methods...
}