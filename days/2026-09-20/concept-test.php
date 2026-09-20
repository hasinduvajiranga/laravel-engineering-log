// tests/FactoryTest.php

namespace Tests\Factories;

use App\Factories\EloquentStatefulFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Tests\DuskTestCase;

class FactoryTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_eloquent_stateful_factory()
    {
        // Create a new instance of the factory with some attributes
        $factory = app(EloquentStatefulFactory::class);
        $user = $factory->create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'post_id' => 1,
        ]);

        // Verify that a Post was created and associated with the User
        $this->assertDatabaseHas($user->id, ['posts' => 1]);
    }
}