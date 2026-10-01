// File: tests/Unit/EloquentConnectionsTest.php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Support\Facades\Connection;
use Pest\Laravel\TestCase;

class EloquentConnectionsTest extends TestCase
{
    public function testReadConnection()
    {
        $user = new User();
        $readConnection = $user->getReadConnection();

        $this->assertEquals('mysql', $readConnection->getName());
        $this->assertInstanceOf(\Illuminate\Database\Connectors\Connector, $readConnection);
    }

    public function testWriteConnection()
    {
        $user = new User();
        $writeConnection = $user->getWriteConnection();

        $this->assertEquals('mysql', $writeConnection->getName());
        $this->assertInstanceOf(\Illuminate\Database\Connectors\Connector, $writeConnection);

        // Test that the write connection is not used by default
        $this->assertFalse($writeConnection->isUsingDefault());
    }
}