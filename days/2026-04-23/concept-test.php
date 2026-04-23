// tests/Services/CacheManagerTest.php

namespace Tests\Services;

use Illuminate\Support\Facades\Cache;
use Tests\TestCase;
use App\Services\CacheManager;

class CacheManagerTest extends TestCase
{
    public function testGetTaggedCache()
    {
        $cacheManager = new CacheManager(Cache::make('test-tag'));
        
        $this->assertEquals('', $cacheManager->getTaggedCache('test-tag'));
$cacheManager->getTaggedCache('test-tag'));
        
        Cache::put('test-key', 'Hello, World!', 3600);
        Cache::tag('test-tag');
        
        $result = $cacheManager->getTaggedCache('test-tag');
        $this->assertEquals('Hello, World!', $result);
    }

    public function testSetTaggedCache()
    {
        $cacheManager = new CacheManager(Cache::make('test-tag'));
        
        $cacheManager->setTaggedCache('test-key', 'Hello, World!', 3600, 't
'test-tag');
        
        $result = $cacheManager->getTaggedCache('test-tag');
        $this->assertEquals('Hello, World!', $result);
    }

    public function testDeleteTaggedCache()
    {
        Cache::tag('test-tag');
        Cache::put('test-key', 'Hello, World!', 3600);
        
        $cacheManager = new CacheManager(Cache::make('test-tag'));
        
        $cacheManager->deleteTaggedCache('test-tag');
        
        $this->assertNull($cacheManager->getTaggedCache('test-tag'));
    }

    public function testForgetTaggedCache()
    {
        Cache::tag('test-tag');
        Cache::put('test-key', 'Hello, World!', 3600);
        
        $cacheManager = new CacheManager(Cache::make('test-tag'));
        
        $cacheManager->forgetTaggedCache('test-key', 'test-tag');
        
        $result = $cacheManager->getTaggedCache('test-tag');
        $this->assertNull($result);
    }
}