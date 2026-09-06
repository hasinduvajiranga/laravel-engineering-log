# Eloquent Query Caching Strategies

Eloquent provides a simple way to implement query caching by utilizing the `Cache` facade. However, Laravel's built-in caching is not suitable for large-scale applications due to performance concerns.

## Manual Caching using Cache facade
One approach is to manually cache the results of Eloquent queries on construction or retrieval. In this example, we use a model called `Post` to demonstrate how to implement manual query caching.

The `cachePosts()` method fetches the posts from the database and stores them in the cache when an instance of the model is created. The `getPosts()` method retrieves cached results if available; otherwise, it fetches from the database and caches the results for 1 hour using the `Cache::remember` function.

## Benefits of Manual Caching

-   Reduces database queries by caching results
-   Improves performance in large-scale applications
-   Allows custom cache expiration logic

However, manual caching also introduces additional complexity and may not be suitable for all use cases.

## Alternative Approach using Query Cache trait
Laravel 7.0 introduced the `QueryCache` trait that provides a more robust and scalable query caching mechanism. This approach is recommended over manual caching due to its performance benefits and reduced maintenance overhead.

To implement query caching using the `QueryCache` trait, create a new class extending the trait and override the `cachedQuery` method. In this example, we use the same `Post` model but utilize the `QueryCache` trait for improved performance.

```php
// app/Models/Post.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use App\Traits\QueryCache;

class Post extends Model
{
    use QueryCache;

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
```