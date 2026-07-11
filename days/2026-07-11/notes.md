### Blade Conditional Rendering

Blade conditional rendering allows you to render different views based on conditions. This is achieved using the `@if`, `@else if`, and `@else` directives.

#### Example Usage

In the example above, we use the `with()` method to pass a variable to the view. In the controller, we check whether the user is an admin and set the `$isAdmin` variable accordingly.

```php
// app/Http/Controllers/UserController.php

public function index()
{
    // Example data
    $user = [
        'name' => 'John Doe',
        'age' => 30,
        'is_admin' => true,
    ];

    return View::make('users.index', compact('user'))
        ->with([
            'isAdmin' => $user['is_admin'],
        ]);
}
```

The `@if` directive checks whether the variable is true.

```php
// resources/views/users/index.blade.php

@if($isAdmin)
    <p>You are an admin!</p>
@endif
```

If `$isAdmin` is false, the `@else if` directive would be used to check for a different condition. If neither of these conditions are met, the `@else` directive is used.

```php
// resources/views/users/index.blade.php

@if($isAdmin)
    <p>You are an admin!</p>
@else if (!$user->is_admin && $user->has_verified_email())
    <p>This user has a verified email address.</p>
@endif
```

Blade conditional rendering is useful when you need to render different views based on certain conditions. It allows for more flexibility and control over the view rendering process.

### Best Practices

- Use `with()` method to pass variables to views.
- Use `@if` directive to check for true conditions.
- Use `@else if` and `@else` directives as needed.
- Keep conditional logic in view files separate from controller logic.