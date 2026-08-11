// File: App/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class User extends Model
{
    /**
     * Get the orders associated with the user through a HasOneThrough relationship.
     */
    public function orders(): HasManyThrough
    {
        return $this->hasManyThrough(Order::class, OrderItem::class);
    }
}

// File: App/Models/Order.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    /**
     * Get the order items associated with the order.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}

// File: App/Models/OrderItem.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderItem extends Model
{
    /**
     * Get the order associated with the order item.
     */
    public function order(): HasOne
    {
        return $this->hasOne(Order::class);
    }
}