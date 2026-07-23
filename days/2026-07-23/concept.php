// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class User extends Model
{
    protected $fillable = ['name', 'email'];

    public function scopeActiveUsers(Builder $builder)
    {
        return $builder->where('is_active', 1);
    }

    public function scopeSearchBy_name(Builder $builder, string $name)
    {
        return $builder->where('name', 'like', '%' . $name . '%');
    }
}