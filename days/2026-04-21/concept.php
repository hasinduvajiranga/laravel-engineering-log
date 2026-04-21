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