// tests/Unit/EloquentQueryLoggerTest.php

namespace Tests\Unit;

use App\Services\EloquentQueryLogger;
use Illuminate\Support\Facades\Log;

class EloquentQueryLoggerTest extends TestCase
{
    public function testLogQuery()
    {
        $logger = new EloquentQueryLogger();

        $query = 'SELECT * FROM users';
        $result = $logger->log($query);

        $this->assertEquals($result, ['sql' => $query]);
    }

    public function testLogEagerLoads()
    {
        $logger = new EloquentQueryLogger();
        $models = [
            (object) ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com'],
            (object) ['id' => 2, 'name' => 'Jane Doe', 'email' => 'jane@example.com']
        ];

        $relations = [
            'orders' => 'user_id'
        ];

        $logger->logEagerLoads($models, $relations);

        // Check if the logs are recorded
        $logs = Log::records('eloquent_queries');
        $this->assertCount(2, $logs);
    }
}