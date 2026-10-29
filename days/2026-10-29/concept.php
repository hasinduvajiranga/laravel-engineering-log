// File: app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\MacAddressable;

class User extends Model
{
    use HasFactory, MacAddressable;

    protected $fillable = [
        'name',
        'email',
        'mac_address',
        // Add 'api_token' to the fillable array for API token management
        'api_token'
    ];

    public function apiTokens()
    {
        return $this->hasMany(ApiToken::class);
    }
}

// File: app/Models/ApiToken.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Access\Authorizable;

class ApiToken extends Model
{
    use Authorizable;

    protected $fillable = [
        'token',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}