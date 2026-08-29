// File: app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class User extends Model
{
    protected $guarded = [
        'password',
        // You can add more attributes as needed
    ];

    public function setPasswordAttribute($value)
    {
        if ($this->isDirty('password')) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = $value;
        $this->attributes['password_confirmation'] = $value; // Set password_confirmation to the same value as password
    }
}