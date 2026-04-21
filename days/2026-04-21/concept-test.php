// tests/Unit/Binds/DatabaseTest.php

namespace Tests\Unit\Bindings;

use Illuminate\Foundation\Testing\DatabaseMigrationsEnabled;
use Illuminate\Foundation\Testing\TestCase;
use App\Bindings\DatabaseInterface;
use App\Container\Container;
use Mockery;

class DatabaseTest extends TestCase
{
    use DatabaseMigrationsEnabled;

    public function testFind()
    {
        $container = new Container();
        $database = Mockery::mock(Database::class);
        $container->get('database')->replace($database);

        $model = \App\Models\User::factory()->create();

        $result = $database->find(\App\Models\User::class, ['id' => $model-
$model->id]);

        $this->assertEquals($model, $result);

        $database->assertHasCallCount('where', 1);
    }
}

// tests/Unit/Binds/RepositoryTest.php

namespace Tests\Unit\Bindings;

use Illuminate\Foundation\Testing\DatabaseMigrationsEnabled;
use Illuminate\Foundation\Testing\TestCase;
use App\Bindings\RepositoryInterface;
use Mockery;

class RepositoryTest extends TestCase
{
    use DatabaseMigrationsEnabled;

    public function testFind()
    {
        $container = new Container();
        $database = Mockery::mock(Database::class);
        $repository = \App\Models\User::factory()->create();

        $container->get('database')->replace($database);

        $result = $database->find(\App\Models\User::class, ['id' => $reposi
$repository->id]);

        $this->assertEquals($repository, $result);

        $database->assertHasCallCount('where', 1);
    }
}

// tests/Unit/Binds/AppTest.php

namespace Tests\Unit\Bindings;

use Illuminate\Foundation\Testing\DatabaseMigrationsEnabled;
use Illuminate\Foundation\Testing\TestCase;
use Mockery;

class AppTest extends TestCase
{
    use DatabaseMigrationsEnabled;

    public function testRegisterBinding()
    {
        $container = new Container();

        $database = \App\Bindings\Database::class;

        $container->registerBinding('database', $database);

        $this->assertEquals($database, $container->getBinding('database'));
$container->getBinding('database'));
    }
}