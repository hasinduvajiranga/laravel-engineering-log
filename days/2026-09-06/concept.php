// models/Post.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Post extends Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Cache the query results on construction for the first time
        if (!Cache::has('posts')) {
            $this->cachePosts();
        }
    }

    protected function cachePosts()
    {
        // Fetch posts from database and store them in the cache
        $posts = self::all();

        // Cache the results for 1 hour
        Cache::put('posts', $posts, now()->addHour());
    }

    public static function getPosts()
    {
        // Retrieve cached results or fetch from database if not available
        return Cache::remember('posts', 60, function () {
            return self::all();
        });
    }
}