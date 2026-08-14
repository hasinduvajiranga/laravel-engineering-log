// Define a model for the first entity (e.g., User)
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Model
{
    // Define the many-to-many relationship with the second entity
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'user_post', 'user_id', 'post_id');
    }
}

// Define a model for the second entity (e.g., Post)
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    // Define the many-to-many relationship with the first entity
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_post', 'post_id', 'user_id');
    }
}