// File: app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class User extends Model
{
    protected $fillable = ['name', 'email'];

    public function scopeRawWhere($query, $attribute, $value)
    {
        return $query->where Raw($attribute . '=', $value);
    }

    public function scopeRawLike($query, $column, $pattern)
    {
        return $query->whereRaw($column . " LIKE ?", [$pattern]);
    }
}