### Laravel Horizon Configuration

Laravel Horizon is a simple and powerful tool for monitoring and managing b
background jobs. It allows you to create scheduled commands that can be run
run at specific intervals or on demand.

#### Installing and Configuring Laravel Horizon

To install Laravel Horizon, run the following command:

```bash
composer require rappi/horizon
```

Next, add the `HorizonServiceProvider` to your application's service provid
provider in the `config/app.php` file:

```php
'providers' => [
    // ...
    App\Providers\HorizonServiceProvider::class,
],
```

#### Configuration Options

Laravel Horizon provides several configuration options that can be customiz
customized to suit your needs. Some of the most common options include:

*   `delay`: The time in seconds before a background job is executed.
*   `maxRetries`: The maximum number of times a background job should be re
retried if it fails.
*   `maxTime`: The maximum amount of time (in seconds) that a background jo
job can take to complete.

These options can be customized by setting values in the `horizon` section 
of your application's configuration file (`config/horizon.php`).

#### Creating Scheduled Commands

Scheduled commands are used to run background jobs at specific intervals or
or on demand. To create a scheduled command, you can use the `Schedule::com
`Schedule::command()` method provided by Laravel.

```php
use Illuminate\Support\Facades\Schedule;

class MyScheduledCommand extends Command
{
    public function handle()
    {
        // Code to be executed when the command is run.
    }
}

// Schedule the command to run every hour
Schedule::command('MyScheduledCommand')->hourly();
```

#### Using Laravel Horizon in Your Application

Laravel Horizon can be used to monitor and manage background jobs in your a
application. You can use the `Horizon` facade to interact with the Horizon 
console.

```php
use Rappi\Horizon\Horizon;

$horizon = app(Horizon::class);

// Start a new job
$job = $horizon->createJob(new MyBackgroundJob());

// Run a scheduled command
$scheduleCommand = $horizon->command('MyScheduledCommand');
$scheduleCommand->run();
```

#### Additional Configuration Options

Some additional configuration options are available in the `HorizonServiceP
`HorizonServiceProvider` class.

```php
class HorizonServiceProvider extends ServiceProvider
{
    public function register()
    {
        // ...

        $this->app->singleton(Horizon::class, function ($app) {
            return new Horizon(
                Config::get('horizon', [
                    'delay' => 60,
                    'maxRetries' => 3,
                    'maxTime' => 30,
                ]),
                [
                    // ...
                ]
            );
        });
    }
}
```

In this example, we're overriding the default configuration options for Hor
Horizon.