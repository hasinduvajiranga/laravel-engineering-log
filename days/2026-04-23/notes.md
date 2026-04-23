# Laravel Cache Tags

Laravel Cache Tags provide a simple way to cache data with tags. Tags can b
be used to filter, group, or prioritize cached data.

## Using Cache Tags in Laravel

To use cache tags in Laravel, you need to install the `memcached` package a
and configure it in your `.env` file.

```php
// .env
MEMCACHED_HOST=127.0.0.1
```

Once configured, you can create a new instance of the `CacheManager` class,
class, which extends the built-in Laravel cache manager.

```php
use Illuminate\Support\Facades\Cache;
use App\Services\CacheManager;

$cacheManager = new CacheManager(Cache::make('test-tag'));
```

## Methods

The `CacheManager` class provides several methods for working with cache ta
tags:

- `getTaggedCache($tag)`: Retrieves the cached data associated with the spe
specified tag.
- `setTaggedCache($key, $value, int $minutes, string $tag = null)`: Sets th
the value of a key in the cache with the specified tag and time to live.
- `deleteTaggedCache($tag)`: Deletes all cached data associated with the sp
specified tag.
- `forgetTaggedCache($key, string $tag = null)`: Forgets the cached data as
associated with the specified key or tag.

## Example Use Case

Suppose you want to cache a list of articles for a specific category. You c
can use cache tags to group these articles together and retrieve them using
using a single method call.

```php
use App\Services\CacheManager;

$cacheManager = new CacheManager(Cache::make('category-articles'));

// Retrieve all articles for the 'Category A' tag
$articlesA = $cacheManager->getTaggedCache('category-a');

// Retrieve all articles for the 'Category B' tag
$articlesB = $cacheManager->getTaggedCache('category-b');
```

You can also use cache tags to prioritize or filter cached data. For exampl
example, you can store a tag indicating which articles were last updated an
and retrieve them using this tag.

```php
use App\Services\CacheManager;

$cacheManager = new CacheManager(Cache::make('latest-updated'));

// Store the latest update time for 'Article X' with the 'latest-updated' t
tag
$cacheManager->setTaggedCache('article-x', '2023-03-10T14:30:00Z', 3600, 'l
'latest-updated');

// Retrieve all articles that were last updated on or after March 10th, 202
2023
$articles = $cacheManager->getTaggedCache('latest-updated');
```