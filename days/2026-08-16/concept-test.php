// File: tests/Unit/EloquentQueryLogTest.php

namespace Tests\Unit;

use App\Providers\EloquentQueryLog;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\TestCase;

class EloquentQueryLogTest extends TestCase
{
    private $eloquentQueryLog;

    public function setUp()
    {
        parent::setUp();
        $this->eloquentQueryLog = new EloquentQueryLog();
    }

    public function testGetQueryLog()
    {
        // Test get query log data
        $queryLogData = $this->eloquentQueryLog->getQueryLog();

        $this->assertIsArray($queryLogData);
        foreach ($queryLogData as $data) {
            $this->assertIsArray($data);
            $this->assertStringStartsWith('sql:', $data['sql']);
            $this->assertArrayHasKey('bindings', $data);
            $this->assertArrayHasKey('time', $data);
        }
    }

    public function testLogQuery()
    {
        // Test log query data
        $sql = 'SELECT * FROM users';
        $bindings = ['id'];
        $this->eloquentQueryLog->logQuery($sql, $bindings);

        // Check if the message was logged with the correct bindings and time
        $loggerMessage = Log::getMessages();
        foreach ($loggerMessage as $message) {
            if ($message['level'] === 'debug' && $message['data']['sql'] == $sql) {
                $this->assertEquals($bindings, $message['data']['bindings']);
                $this->assertIsFloat($message['data']['time']);
            }
        }
    }

    public function testGetQueryLogMultiple()
{
        // Test get query log data
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $queryLogData = $this->eloquentQueryLog->getQueryLog();

        $this->assertIsArray($queryLogData);
        foreach ($queryLogData as $data) {
            $this->assertIsArray($data);
            $this->assertStringStartsWith('sql:', $data['sql']);
            $this->assertArrayHasKey('bindings', $data);
            $this->assertArrayHasKey('time', $data);

            // Ensure that the query is related to 'users' table
            if ($data['sql'] === 'SELECT * FROM users') {
                $this->assertEquals(1, $data['bindings']['id']);
            }
        }

    }
}