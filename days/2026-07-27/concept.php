namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class User extends Model
{
    protected $fillable = ['name', 'email'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // Create a query builder for retrieving users with their posts
    public static function getUsersWithPosts()
    {
        return self::with('posts')->get();
    }
}