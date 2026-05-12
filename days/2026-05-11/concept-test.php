// tests/PerformanceOptimizerTest.php

namespace Tests;

use App\Services\PerformanceOptimizer;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Foundation\Testing\TestCase;

class PerformanceOptimizerTest extends TestCase
{
    public function testOptimizeQueries()
    {
        $cache = Cache::make('test-cache');
        $redis = Redis::make('test-redis');

        $performanceOptimizer = new PerformanceOptimizer($cache, $redis);

        // Create sample queries and cache keys
        $queries = [
            ['tableName' => 'users', 'id' => 1, 'conditions' => 'id=1'],
            ['tableName' => 'posts', 'id' => 2, 'conditions' => 'id=2'],
        ];

        foreach ($queries as $query) {
            $query['cacheKey'] = strval($query['id']) . '_query_' . uniqid(
uniqid();
        }

        // Optimize queries
        $optimizedQueries = $performanceOptimizer->optimizeQueries($queries
$performanceOptimizer->optimizeQueries($queries);

        // Assert cache hits and redis values match cache results
        foreach ($optimizedQueries as $result) {
            $cacheKey = $result['cacheKey'] ?? null;
            if ($cacheKey) {
                $expectedResult = Cache::make('test-cache')->get($cacheKey)
Cache::make('test-cache')->get($cacheKey);
                $this->assertEquals($expectedResult, $result['results']);
            } else {
                $redisValue = Redis::make('test-redis')->get($result['table
Redis::make('test-redis')->get($result['tableName'] . '_' . $result['id']);
$result['id']);
                $this->assertEquals(json_decode($result['res
$this->assertEquals(json_decode($result['results'], true), json_decode($red
json_decode($redisValue, true));
            }
        }
    }

    public function testOptimizeRoutes()
    {
        // Create sample routes and cache keys
        $routes = [
            ['model' => 'User', 'id' => 1, 'conditions' => 'id=1'],
            ['model' => 'Post', 'id' => 2, 'conditions' => 'id=2'],
        ];

        foreach ($routes as $route) {
            $route['cacheKey'] = strval($route['id']) . '_route_' . uniqid(
uniqid();
        }

        // Optimize routes
        $performanceOptimizer = new PerformanceOptimizer(Cache::make('test-
PerformanceOptimizer(Cache::make('test-cache'), Redis::make('test-redis'));
Redis::make('test-redis'));

        $optimizedRoutes = $performanceOptimizer->optimizeRoutes($routes);

        // Assert cache hits and redis values match cache results
        foreach ($optimizedRoutes as $result) {
            $cacheKey = $result['cacheKey'] ?? null;
            if ($cacheKey) {
                $expectedResult = Cache::make('test-cache')->get($cacheKey)
Cache::make('test-cache')->get($cacheKey);
                $this->assertEquals($expectedResult, json_decode($result['r
json_decode($result['results'], true));
            } else {
                $redisValue = Redis::make('test-redis')->get($result['model
Redis::make('test-redis')->get($result['model'] . '_' . $result['id']);
                $this->assertEquals(json_decode($result['results'], true), 
json_decode($redisValue, true));
            }
        }
    }

    public function testOptimizeQueriesWithNestedQueries()
    {
        // Create sample queries with nested queries
        $queries = [
            ['tableName' => 'users', 'id' => 1, 'conditions' => 'id=1'],
            ['tableName' => 'posts', 'id' => 2, 'conditions' => 'id=2'],
            ['tableName' => 'comments', 'id' => 3, 'conditions' => 'post_id
'post_id=' . $queries[1]['id']],
        ];

        // Optimize queries
        $performanceOptimizer = new PerformanceOptimizer(Cache::make('test-
PerformanceOptimizer(Cache::make('test-cache'), Redis::make('test-redis'));
Redis::make('test-redis'));

        $optimizedQueries = $performanceOptimizer->optimizeQueries($queries
$performanceOptimizer->optimizeQueries($queries);

        // Assert cache hits and redis values match cache results
        foreach ($optimizedQueries as $result) {
            $cacheKey = $result['cacheKey'] ?? null;
            if ($cacheKey) {
                $expectedResult = Cache::make('test-cache')->get($cacheKey)
Cache::make('test-cache')->get($cacheKey);
                $this->assertEquals($expectedResult, json_decode($result['r
json_decode($result['results'], true));
            } else {
                $redisValue = Redis::make('test-redis')->get($result['table
Redis::make('test-redis')->get($result['tableName'] . '_' . $result['id']);
$result['id']);
                $this->assertEquals(json_decode($result['res
$this->assertEquals(json_decode($result['results'], true), json_decode($red
json_decode($redisValue, true));
            }
        }

        // Assert nested queries have correct results
        foreach ($queries as $query) {
            if (isset($query['relatedQuery'])) {
                $expectedResult = $performanceOptimizer->optimizeQueries([$
$performanceOptimizer->optimizeQueries([$query['relatedQuery']])[0];
                $this->assertEquals(json_decode($expectedResult, true), jso
json_decode($result['results'], true));
            }
        }
    }

    public function testOptimizeRoutesWithNestedRoutes()
    {
        // Create sample routes with nested routes
        $routes = [
            ['model' => 'User', 'id' => 1, 'conditions' => 'id=1'],
            ['model' => 'Post', 'id' => 2, 'conditions' => 'id=2'],
            ['model' => 'Comment', 'id' => 3, 'conditions' => 'post_id=' . 
$routes[1]['id']],
        ];

        // Optimize routes
        $performanceOptimizer = new PerformanceOptimizer(Cache::make('test-
PerformanceOptimizer(Cache::make('test-cache'), Redis::make('test-redis'));
Redis::make('test-redis'));

        $optimizedRoutes = $performanceOptimizer->optimizeRoutes($routes);

        // Assert cache hits and redis values match cache results
        foreach ($optimizedRoutes as $result) {
            $cacheKey = $result['cacheKey'] ?? null;
            if ($cacheKey) {
                $expectedResult = Cache::make('test-cache')->get($cacheKey)
Cache::make('test-cache')->get($cacheKey);
                $this->assertEquals($expectedResult, json_decode($result['r
json_decode($result['results'], true));
            } else {
                $redisValue = Redis::make('test-redis')->get($result['model
Redis::make('test-redis')->get($result['model'] . '_' . $result['id']);
                $this->assertEquals(json_decode($result['results'], true), 
json_decode($redisValue, true));
            }
        }

        // Assert nested routes have correct results
        foreach ($routes as $route) {
            if (isset($route['relatedRoute'])) {
                $expectedResult = $performanceOptimizer->optimizeRoutes([$r
$performanceOptimizer->optimizeRoutes([$route['relatedRoute']])[0];
                $this->assertEquals(json_decode($expectedResult, true), jso
json_decode($result['results'], true));
            }
        }
    }
}