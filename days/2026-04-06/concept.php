// Define a base model for the User entity
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    // Define a polymorphic relationship with the Post entity
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'user_id');
    }
}

// Define a model for the Post entity that has a user_id foreign key
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    // Define a relationship with the User entity that has an inverse on th
the posts() method
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Define a polymorphic pivot table for the many-to-many relationship
    protected $table = 'post_user_pivot';
}

// Define a model for the Comment entity that has a post_id foreign key
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    // Define a relationship with the Post entity that has an inverse on th
the comments() method
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'post_id');
    }

    // Define a polymorphic pivot table for the many-to-many relationship
    protected $table = 'comment_post_pivot';
}