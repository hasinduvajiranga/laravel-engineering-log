// App\Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Model
{
    protected $fillable = ['name', 'email'];

    public function posts(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}

// App\Models\Post.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    protected $fillable = ['title', 'content'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}