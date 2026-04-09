# Laravel Horizon Configuration

Laravel Horizon is a queue management system that allows you to manage and 
monitor your queues. It's an extension of the Laravel framework that provid
provides a simple way to manage jobs in your application.

### Installing Horizon

To install Horizon, run the following command:

```bash
composer require laravel/horizon
```

### Configuring Horizon

You can configure Horizon by creating a `horizon.php` file in the `config` 
directory. This file contains configuration settings for Horizon, such as t
the queue configuration.

Here's an example of what the `horizon.php` file might look like:

```php
// config/horizon.php

return [
    'queue' => [
        // Your queue configuration here
        'default' => ['job-class' => App\Jobs\MyJob::class],
    ],
];
```

In this example, we're configuring the default queue to use the `MyJob` job
job class.

### Running Horizon Commands

You can run Horizon commands using the following command:

```bash
php artisan horizon:config
```

This command will configure Horizon with the specified configuration settin
settings.

### Testing Horizon Configuration

To test Horizon configuration, you can create a test that checks if the con
configuration is set correctly. Here's an example of how you might write su
such a test:

```php
// tests/Console/Commands/HorizonConfigCommandTest.php

namespace Tests\Console\Commands;

use App\Console\Commands\HorizonConfigCommand;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;

class HorizonConfigCommandTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_configures_horizon()
    {
        $this->assertNull(Config::get('horizon'));

        (new HorizonConfigCommand)->handle();

        $this->assertEquals([
            'queue' => [
                'default' => ['job-class' => App\Jobs\MyJob::class],
            ],
        ], Config::get('horizon'));
    }
}
```