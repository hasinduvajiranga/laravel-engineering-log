// tests/Unit/FactoryTest.php
namespace Tests\Unit;

use App\Factory\EloquentFactory;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Facades\Schema;

class FactoryTest extends TestCase
{
    public function testHasFactory()
    {
        $factory = new EloquentFactory();
        $this->assertTrue($factory->hasFactory());
    }

    public function testDefinitionReturnsAnArray()
    {
        $factory = new EloquentFactory();
        $definition = $factory->definition();

        $this->assertIsArray($definition);
    }
}