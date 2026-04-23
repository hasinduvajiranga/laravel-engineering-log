// App/Services/CacheManager.php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Cache\MemcachedStore;

class CacheManager
{
    private $memcachedStore;

    public function __construct(MemcachedStore $memcachedStore)
    {
        $this->memcachedStore = $memcachedStore;
    }

    public function getTaggedCache(string $tag)
    {
        return $this->memcachedStore->get($tag);
    }

    public function setTaggedCache(string $key, string $value, int $minutes
$minutes, string $tag = null)
    {
        $this->memcachedStore->put($key, $value, $minutes);
        
        if ($tag) {
            $this->memcachedStore->tag($key, $tag);
        }
    }

    public function deleteTaggedCache(string $tag)
    {
        $this->memcachedStore->forget($tag);
    }

    public function forgetTaggedCache(string $key, string $tag = null)
    {
        if ($tag) {
            $this->memcachedStore->unTag($key, $tag);
        }
        
        $this->memcachedStore->forget($key);
    }
}