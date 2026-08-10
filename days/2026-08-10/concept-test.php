// tests/Database/Factories/UserTest.php

namespace Tests\Database\Factories;

use App\Database\Factories\UserFactory;
use Tests\TestCase;

class UserFactoryTest extends TestCase
{
    public function test_user_factory()
    {
        $user = User::factory()->create();

        $this->assertNotNull($user->id);
        $this->assertEquals(1, $user->id);

        $this->assertInstanceOf(User::class, $user->getUserSequence());
    }
}
```

```php
// tests/Database/Factories/UserSequenceTest.php

namespace Tests\Database\Factories;

use App\Database\Factories\UserSequenceFactory;
use Tests\TestCase;

class UserSequenceFactoryTest extends TestCase
{
    public function test_user_sequence_factory()
    {
        $sequence = UserSequence::factory()->create();

        $this->assertNotNull($sequence->id);
        $this->assertEquals(10, Str::length($sequence->sequence_number));
        $this->assertTrue($sequence->is_verified);

        $user = User::where('email', $sequence->email)->first();
        $this->assertInstanceOf(UserSequence::class, $user->getUserSequence());
    }
}