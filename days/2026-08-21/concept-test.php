// File: tests/Database/Connectors/EloquentTest.php

use App\Database\Connectors\EloquentConnector;
use Illuminate\Support\Facades\Config;
use PHPUnit\Framework\TestCase;

class EloquentTest extends TestCase
{
    public function testGetConnections()
    {
        $connector = app(EloquentConnector::class);
        $connections = $connector->getConnections();
        $this->assertEquals(['mysql' => 'mysql'], $connections);
    }

    public function testGetConnection()
    {
        $connector = app(EloquentConnector::class);
        $connection = $connector->getConnection('mysql');
        $this->assertEquals(config('database.connections.mysql'), $connection);
    }
}

// Test to check if the connection swapping works correctly
class ConnectionSwappingTest extends TestCase
{
    public function testConnectionSwapping()
    {
        Config::set('database.connections.mysql', 'test');

        app(EloquentConnector::class);

        $connections = app(EloquentConnector::class)->getConnections();
        $this->assertEquals(['mysql' => 'test'], $connections);
    }
}