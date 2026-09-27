# Eloquent Column Modifications

Eloquent provides a flexible way to modify the behavior of database columns using several methods.

### Fillable Columns

To specify which columns can be mass-assigned, use the `$fillable` property on your model. This should include only the column names that you intend to allow mass-assignment for.

```php
protected $fillable = [
    'name',
    'email',
];
```

### Hidden Columns

To exclude certain columns from being returned in the API response or when retrieving data, use the `$hidden` property on your model. This should include only the column names that you intend to hide.

```php
protected $hidden = [
    'password', 'remember_token',
];
```

### Casted Columns

To modify the type of a column after it is retrieved from the database, use the `$casts` property on your model. This allows you to specify how the data should be cast when retrieved.

```php
protected $casts = [
    'price' => 'decimal:2',
];
```

### Attribute Modification

To modify the attributes of an Eloquent instance after it is created or updated, use the `getAttribute` and `setAttribute` methods. This allows you to update specific columns on your model even if they are not included in the `$fillable` property.

```php
$user = new User();
$user->name = 'John Doe';
$user->stock_quantity = 10;
```

### Validation

Eloquent provides validation for the model's attributes using the `validate` method. This can be used to ensure that data being inserted into the database meets certain requirements.

```php
$this-> validate($user, [
    'name' => 'required|string',
    'email' => 'required|email|unique:users',
]);
```

### Observers

Eloquent provides an observer system for models using the `ObservesEvents` trait. This allows you to define custom events that can be triggered on specific model events.

```php
namespace App\Observers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Events\Dispatcher;

class UserObserver implements ModelObserverContract
{
    public function handleUserCreated(User $user)
    {
        // Handle user created event
    }
}
```

### Events

Eloquent provides an events system for models using the `Events` trait. This allows you to define custom events that can be triggered on specific model events.

```php
namespace App\Listeners;

use App\Models\User;
use Illuminate\Contracts\Events\Dispatcher;

class SendWelcomeEmail implements ShouldListen
{
    public function handle(User $user)
    {
        // Handle welcome email event
    }
}
```

This is a basic example of how to modify Eloquent column behavior in Laravel. You can customize and extend this using various other methods and traits provided by the framework.