// File: App/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class User extends Model
{
    protected $fillable = ['name', 'email'];

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'user_orders');
    }

    public function getOrdersByDateRange($startDate, $endDate)
    {
        return $this->orders()->whereBetween('created_at', [$startDate, $endDate]);
    }
}