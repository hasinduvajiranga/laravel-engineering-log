# Custom Artisan Commands

Custom Artisan commands allow you to extend the functionality of Laravel's 
command-line interface. They provide a flexible way to automate tasks and i
interact with your application.

## Creating a New Command

To create a new custom Artisan command, open the `app/Console/Commands` dir
directory and create a new PHP file (e.g., `CreateUser.php`). Define the na
namespace and class structure for your command.

```php
namespace App\Console\Commands;

use Illuminate\Console\Command;
```

Then, define the signature of your command using the `$signature` property.
property. The syntax is `command:name {option1} [argument1]`.

```php
protected $signature = 'create:user {name} {email}';
```

Next, implement the logic for your command in the `handle` method.

```php
public function handle()
{
    // Command logic here
}
```

## Testing Custom Commands

To test a custom Artisan command, you can use Pest or PHPUnit. Here's an ex
example using Pest:

```php
use App\Console\Commands.CreateInstance;

it('should create a new user', fn () {
    Instance::create(['name' => 'John Doe', 'email' => 'john@example.com'])
'john@example.com']);
});
```

Or here's an example using PHPUnit:

```php
use App\Console\Commands_CreateUser;
use App\Models_User;

public function testCreateUserSuccess()
{
    $user = new CreateUser();
    $user->handle(['name' => 'John Doe', 'email' => 'john@example.com']);

    $this->assertInstanceOf(User::class, $user);
    $this->assertEquals('John Doe', $user->name);
}
```

## Best Practices

When creating custom Artisan commands:

*   Keep your command logic simple and focused on a single task.
*   Use descriptive variable names and follow the PSR-1 coding standard.
*   Consider adding validation to ensure data integrity.
*   Test your commands thoroughly using Pest or PHPUnit.