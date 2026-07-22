// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class User extends Model
{
    public function scopeActive($query, $value)
    {
        return $query->where('is_active', true);
    }

    public function scopeAdmin($query, $value)
    {
        return $query->where('role', 'admin');
    }
}