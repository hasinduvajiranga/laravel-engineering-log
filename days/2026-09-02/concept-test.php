// tests/ModelTest.php

namespace Tests\Unit;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class ModelTest extends TestCase
{
    public function test_casting_user_attributes()
    {
        $user = new User(['name' => 'John Doe', 'email' => 'john@example.com']);

        $this->assertEquals([
            'attributes' => [
                'name' => 'John Doe',
                'email' => 'john@example.com',
            ],
        ], json_decode($user->attributes, true));
    }

    public function test_casting_user_attributes_with_empty_array()
    {
        $user = new User(['attributes' => []]);

        $this->assertEquals([], json_decode($user->attributes, true));
    }
}