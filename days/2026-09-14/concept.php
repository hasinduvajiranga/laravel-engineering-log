// Models/User.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination Paginate;

class User extends Model
{
    protected $fillable = [
        'name', 
        'email'
    ];

    public function scopePaginated($query, $perPage)
    {
        return $query->paginate($perPage);
    }
}