# Eloquent API Webhooks

Eloquent is a powerful ORM (Object-Relational Mapping) tool in Laravel that provides an elegant way to interact with your database. When it comes to webhooks, you want to ensure that they are properly registered and dispatched. Here's how we can use Eloquent to manage webhooks in our application.

## Webhook Model

Create a `Webhook` model to store webhook data:
```php
// app/Models/Webhook.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Webhook extends Model
{
    protected $fillable = ['event', 'payload'];

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}
```

## Webhook Registry

Create a `WebhookRegistry` class to handle webhook registration and dispatching:
```php
// app/Http/Kernel.php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use App\Models\Webhook;

class Kernel extends HttpKernel
{
    public function register()
    {
        // Register webhooks
        $this->app['event'] = new Event();
        $this->app->bind('webhook', function ($app) {
            return new Webhook($app['webhook']);
        });
    }
}
```

## Livewire Component

Create a `WebhookLivewire` component to handle webhook data and dispatching:
```php
// app/Http/Livewire/WebhookLivewire.php (above)
```

This implementation provides a basic framework for managing webhooks in Laravel using Eloquent. You can extend this example to fit your specific use case.