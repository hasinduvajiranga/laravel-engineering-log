# Laravel Service Container Binding

In this example, we're exploring the use of service container binding in La
Laravel to decouple our business logic from the underlying database layer.

## Database Binding

We create a `Database` class that implements `DatabaseInterface`. This inte
interface defines a method `find` which takes a model and conditions as arg
arguments. The `find` method is then used by other classes to retrieve data
data from the database.

```php
// app/Bindings/Database.php

namespace App\Bindings;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\Container\Container;
use App\Bindings\DatabaseInterface;

class Database implements DatabaseInterface
{
    private $connection;

    public function __construct(Container $container)
    {
        $this->connection = $container->get('database');
    }

    public function find(Model $model, array $conditions): ?Model
    {
        return $this->connection->where($conditions)->first();
    }
}
```

## Repository Binding

We create a `Repository` class that implements `RepositoryInterface`. This 
interface defines a method `find` which takes an id as an argument. The `fi
`find` method is then used by other classes to retrieve data from the datab
database.

```php
// app/Bindings/Repository.php

namespace App\Bindings;

use App\Models\User;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\Container\Container;
use App\Bindings\RepositoryInterface;

class Repository implements RepositoryInterface
{
    private $model;
    private $database;

    public function __construct(Container $container, User $model)
    {
        $this->model = $model;
        $this->database = app(Database::class);
    }

    public function find(string $id): ?User
    {
        return $this->database->find($this->model, ['id' => $id]);
    }
}
```

## Model Binding

We create a `User` model that implements the `RepositoryInterface`.

```php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Bindings\RepositoryInterface;

class User extends Model implements RepositoryInterface
{
    use RepositoryTrait;

    public function find(string $id): ?self
    {
        return self::where('id', $id)->first();
    }
}
```

## Container Binding

We create a `Container` class that defines the bindings for our application
application. In this case, we're binding the `Database` class to the `'data
`'database'` key.

```php
// app/Container.php

namespace App\Container;

use Illuminate\Support\Facades\App;
use Illuminate\Foundation\Application as LaravelApplication;

class Container extends LaravelApplication
{
    protected $bindings = [];

    public function registerBinding(string $name, string $bindingClass)
    {
        $this->bindings[$name] = $bindingClass;
    }

    public function getBinding(string $name): ?string
    {
        return $this->bindings[$name];
    }
}
```

## Testing

We create test classes to verify that the bindings are working as expected.
expected.

```php
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
```

By using service container binding, we've decoupled our business logic from
from the underlying database layer. This makes it easier to switch out diff
different databases or implement mocking for unit testing.

In conclusion, service container binding is a powerful tool in Laravel that
that allows you to decouple your application's dependencies and make it eas
easier to test and maintain.