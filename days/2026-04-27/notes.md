# Custom Artisan Commands

Custom Artisan commands are classes that extend the `Illuminate\Console\Com
`Illuminate\Console\Command` class and implement the necessary methods to d
define the command's behavior.

## Creating a Command Class

To create a new command class, use the following namespace and class struct
structure:

```php
namespace App\Console\Commands;

use Illuminate\Console\Command;
```

Then, define the command's signature using the `$signature` property:

```php
protected $signature = 'hello:world';
```

Next, implement the `handle()` method to execute the command's logic. This 
is where you put your business logic.

## Logging and Output

To log messages or print output during the execution of a command, use Lara
Laravel's logging facade (`app(Log::class)`). You can also use methods like
like `info()`, `debug()`, etc., which are provided by the `Illuminate\Conso
`Illuminate\Console\Command` class itself.

```php
Log::info('Hello World!');
$this->info('Hello World!');
```

## Testing Commands

To test a command, you need to create a test class that extends the `TestCa
`TestCase` class. Use the `artisan()` method to execute the command and the
then assert its output using methods like `assertEquals()`, `assertTrue()`,
`assertTrue()`, etc.

```php
$this->artisan('hello:world');
$this->assertEquals('Hello World!', $this->output());
```

You can also test logging by verifying that a certain number of log records
records have been written to the logger:

```php
$logger = app(Log::class);

$this->artisan('hello:world');

$logger->assertLogRecordCount(Log::DEBUG, 1);
```