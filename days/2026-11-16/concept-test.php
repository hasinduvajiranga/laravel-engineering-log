// tests/Loggers/EloquentLoggerTest.php

namespace Tests\Loggers;

use App\Loggers\EloquentLogger;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class EloquentLoggerTest extends TestCase
{
    public function testEloquentLogger()
    {
        // Create a mock model instance
        $model = new \Illuminate\Database\Eloquent\Model(['id' => 1, 'created_at' => now()]);

        // Create an instance of the logger
        $logger = new EloquentLogger($model);

        // Log update events
        $logger->logUpdate();

        // Verify that the log message was recorded correctly
        $this->assertEquals('Updated instance: N/A - 1', Log::recorded('Eloquent Logger'));

        // Log create event
        $logger->logCreate();

        // Verify that the log message was recorded correctly
        $this->assertEquals('Created instance: 2023-03-20 14:30:00 - 1', Log::recorded('Eloquent Logger'));
    }
}