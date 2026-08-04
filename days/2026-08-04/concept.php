// src/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DateTime;

class User extends Model
{
    protected $dates = ['created_at', 'updated_at'];

    public function getCreatedAtAttribute($value)
    {
        return $this->attributes['created_at'] ? new DateTime($value) : null;
    }

    public function setCreatedAtAttribute($value)
    {
        $this->attributes['created_at'] = (new DateTime($value))->format('Y-m-d H:i:s');
    }
}
```

```php
// src/Models/Post.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Post extends Model
{
    protected $dates = ['published_at'];

    public function getPublishedAtAttribute($value)
    {
        return new Carbon($value);
    }

    public function setPublishedAtAttribute($value)
    {
        $this->attributes['published_at'] = Carbon::parse($value)->format('Y-m-d H:i:s');
    }
}