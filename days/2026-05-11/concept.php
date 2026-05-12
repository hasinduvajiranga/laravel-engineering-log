// app/Services/PerformanceOptimizer.php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class PerformanceOptimizer
{
    private $cache;
    private $redis;

    public function __construct(Cache $cache, Redis $redis)
    {
        $this->cache = $cache;
        $this->redis = $redis;
    }

    public function optimizeQueries(array $queries): array
    {
        // Optimize queries by caching and redis
        $optimizedQueries = [];
        foreach ($queries as $query) {
            if (isset($query['cacheKey'])) {
                $cacheResult = $this->cache->get($query['cacheKey']);
                if (!$cacheResult) {
                    $result = DB::table($query['tableName'])->where($query[
DB::table($query['tableName'])->where($query['conditions'])->first();
                    $this->cache->put($query['cacheKey'], $result, $query['
$query['ttl']);
                }
            }

            // Use redis to store query results
            $redisKey = $query['tableName'] . '_' . $query['id'];
            if (!isset($optimizedQueries[$redisKey])) {
                $optimizedQueries[$redisKey] = $this->redis->get($redisKey)
$this->redis->get($redisKey);
            }

            $optimizedQuery = [
                'cacheKey' => isset($query['cacheKey']) ? $query['cacheKey'
$query['cacheKey'] : null,
                'tableName' => $query['tableName'],
                'id' => $query['id'],
                'results' => $this->optimizeResult($result),
            ];

            // Update query with optimized results
            DB::table('queries')->where('id', $query['id'])->update(['resul
$query['id'])->update(['results' => json_encode($optimizedQuery)]);
        }

        return $optimizedQueries;
    }

    private function optimizeResult($result)
    {
        if ($result instanceof \Illuminate\Database\Eloquent\Builder) {
            // Recursively process related queries
            $relatedQueries = $this->optimizeQueries($result->getRelationNa
$this->optimizeQueries($result->getRelationNames());
            return [
                'id' => $result->id,
                'results' => array_merge(['id' => $result->id], $relatedQue
$relatedQueries),
            ];
        } elseif ($result instanceof \Illuminate\Support\Collection) {
            // Flatten result
            $flatResults = [];
            foreach ($result as $item) {
                if (isset($item['relatedQuery'])) {
                    $flatResults[] = ['results' => $this->optimizeResult($i
$this->optimizeResult($item['relatedQuery'])];
                } else {
                    $flatResults[] = ['id' => $item['id']];
                }
            }

            return [
                'id' => $result->first()['id'],
                'results' => array_map(function ($item) {
                    return ['id' => $item['id']];
                }, $flatResults),
            ];
        } else {
            // Return raw result
            return ['id' => $result];
        }
    }

    public function optimizeRoutes(array $routes): array
    {
        // Optimize routes by caching and redis
        $optimizedRoutes = [];
        foreach ($routes as $route) {
            if (isset($route['cacheKey'])) {
                $cacheResult = $this->cache->get($route['cacheKey']);
                if (!$cacheResult) {
                    $result = Route::model($route['model'])->where($route['
Route::model($route['model'])->where($route['conditions'])->first();
                    $this->cache->put($route['cacheKey'], $result, $route['
$route['ttl']);
                }
            }

            // Use redis to store route results
            $redisKey = $route['model'] . '_' . $route['id'];
            if (!isset($optimizedRoutes[$redisKey])) {
                $optimizedRoutes[$redisKey] = $this->redis->get($redisKey);
$this->redis->get($redisKey);
            }

            $optimizedRoute = [
                'cacheKey' => isset($route['cacheKey']) ? $route['cacheKey'
$route['cacheKey'] : null,
                'model' => $route['model'],
                'id' => $route['id'],
                'results' => $this->optimizeResult($result),
            ];

            // Update route with optimized results
            Route::model($route['model'])->where($route['conditions'])->fir
Route::model($route['model'])->where($route['conditions'])->first()->updateRoute::model($route['model'])->where($route['conditions'])->firt()->update(['results' => json_encode($optimizedRoute)]);
        }

        return $optimizedRoutes;
    }
}