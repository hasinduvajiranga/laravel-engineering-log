// File: tests/Services/JsonMutatorTest.php

namespace Tests\Services;

use App\Services\JsonMutator;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use PHPUnit\Framework\TestCase;

class JsonMutatorTest extends TestCase
{
    use DatabaseMigrations;

    public function testApply()
    {
        $mutator = new JsonMutator('json_data');
        $value = '{"key": "value"}';

        self::assertEquals(json_encode($value), $mutator->apply($value));

        $value = 'Invalid JSON';
        self::assertEquals('', $mutator->apply($value));
    }
}