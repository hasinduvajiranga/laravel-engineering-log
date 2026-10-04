// EloquentSlowQueryDetectorTest.php

namespace Tests;

use App\EloquentSlowQueryDetector;
use Laravel\Benchmarking\Benchmark;
use PHPUnit\Framework\TestCase;

class EloquentSlowQueryDetectorTest extends TestCase
{
    protected $detector;

    public function setUp(): void
    {
        parent::setUp();
        $this->detector = new EloquentSlowQueryDetector();
    }

    public function testGetSlowQueries()
    {
        // Create a large number of slow queries
        for ($i = 0; $i < 10000; $i++) {
            $query = $this->detector->newQuery();
            $query->select('id');
            $query->from('slow_queries')->where('duration', '>', 100)->get()->toArray();
        }

        // Verify that the slow query detection worked
        $slowQueries = $this->detector->getSlowQueries();
        $this->assertCount(10, $slowQueries);
    }
}