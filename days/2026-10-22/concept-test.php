// tests/Unit/Model/UserTest.php

namespace Tests\Unit\Model;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use HasFactory, DatabaseMigrations, WithFaker;

    public function testUserHasCorrectFillableAttributes()
    {
        $user = User::factory()->create();

        $fillable = config('database.fillable', []);

        $this->assertEquals($fillable, [
            'name',
            'email',
            'password',
        ]);
    }

    public function testUserRelationOrderIsCorrectlyDefined()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user->id]);

        $this->assertCount(1, $user->orders);
        $this->assertEquals($order->id, $user->orders[0]->id);
    }

    public function testUserFillableAttributeIsCorrectlySet()
    {
        $user = User::factory()->create(['name' => 'John Doe']);

        $this->assertEquals('John Doe', $user->name);

        $user->name = 'Jane Doe';

        $user->save();

        $this->assertEquals('Jane Doe', $user->fresh()->name);
    }
}