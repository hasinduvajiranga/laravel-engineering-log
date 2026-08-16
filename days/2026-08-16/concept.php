// File: app/Providers/EloquentQueryLog.php

namespace App\Providers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Psr \Logging\LoggerInterface;
use Psr \Logging\LogLevel;
use Monolog\Logger as MonologLogger;

class EloquentQueryLog
{
    private $logger;

    public function __construct()
    {
        $this->logger = new MonologLogger('Eloquent Query Log');
        $this->setLevel(LogLevel::DEBUG);
    }

    public function getQueryLog()
    {
        // Collect query log data
        $queryLogData = [];
        foreach (DB::getQueryCache() as $sql) {
            $queryLogData[] = [
                'sql' => $sql['sql'],
                'bindings' => $sql['bindings'],
                'time' => $sql['time']
            ];
        }

        return $queryLogData;
    }

    public function logQuery($sql, array $bindings)
    {
        // Log query data
        $this->logger->debug(
            'Eloquent Query: ' . $sql,
            [
                'bindings' => $bindings,
                'time' => now()
            ]
        );
    }
}