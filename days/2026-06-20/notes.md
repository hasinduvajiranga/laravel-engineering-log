# Controller Filters Removal

Controller filters in Laravel allow you to filter the requests that reach your controllers. However, sometimes you might want to remove these filters or add custom logic before they are applied.

By default, Laravel uses the `Illuminate\Foundation\Http\Middleware\RemoveControllerFilters` middleware to remove controller filters by setting the `$routeKey` property to `'controller'`. This means that any route that is not specifically defined with a route key will automatically have its controller filter removed.

## Removing Controller Filters

To remove controller filters from specific routes, you can use the `Route::macro` method and apply your custom middleware. In this example, we've created a new middleware called `RemoveControllerFilters` that removes the controller filter by default.

You can then apply this middleware to any route using the `apply` method:

```php
$route->apply(new RemoveControllerFilters());
```

Alternatively, you can remove the middleware from routes using the `removeControllerFilter` macro:

```php
Route::get('/original', function () {
    // Route logic here
})->removeControllerFilter();
```

This allows you to customize the behavior of controller filters on a per-route basis.

## Customizing Controller Filters

If you want to add custom logic before the controller filter is applied, you can use the `before` closure in the middleware:

```php
class RemoveControllerFilters extends Middleware
{
    public function handle($request, Closure $next)
    {
        // Add custom logic here
        echo "Custom logic before controller filter\n";
        
        return parent::handle($request, $next);
    }
}
```

In this example, the `before` closure is executed before the controller filter is applied.

By using these techniques, you can remove controller filters from specific routes and add custom logic to customize their behavior.