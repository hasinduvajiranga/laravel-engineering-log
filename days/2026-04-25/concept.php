// models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;

    protected $hidden = [
        'deleted_at',
    ];

    public function scopeIsDeleted($query)
    {
        return $query->where('deleted_at', '<>', null);
    }

    public function scopeRestore($query)
    {
        return $query->update(['deleted_at' => null]);
    }
}
```

```php
// app/Services/UserService.php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function create($data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return $user;
    }

    public function restoreUser(User $user)
    {
        $user->restore();
        return $user;
    }
}