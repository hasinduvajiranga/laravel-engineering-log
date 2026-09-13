// App/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasPagination;

class User extends Model
{
    use HasPagination;

    protected $fillable = ['name', 'email'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}

// App/Models/Order.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasPagination;

class Order extends Model
{
    use HasPagination;

    protected $fillable = ['user_id', 'total'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

// App/Pagination/Users.php

namespace App\Pagination;

use Illuminate\Database\Eloquent\Cursor Pagination;
use Illuminate\Support\Collection;

class UsersPagination extends CursorPagination
{
    protected $models;

    public function __construct(Collection $models)
    {
        parent::__construct($models, 15, ['current_page' => 'current_page'], false);
        $this->models = $models;
    }

    public function getCursor()
    {
        return function () use ($this) {
            return $this->models->cursor();
        };
    }
}