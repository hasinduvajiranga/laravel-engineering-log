# Eloquent API Authentication Flows

Eloquent provides a simple and powerful way to handle authentication flows in Laravel applications. In this example, we will use the built-in `LoginService` class to validate login requests and generate tokens.

## Validation Flow

When handling an incoming login request, we need to validate the user's credentials. We can do this by creating a new instance of our custom `LoginService` class and calling its `validateLoginRequest` method.

```php
// app/services/LoginService.php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\User;

public function validateLoginRequest(Request $request)
{
    // Validate the email address.
    if (!$request->has('email') || !is_string($request->input('email'))) {
        return false;
    }

    // Validate the password.
    if (!$request->has('password') || !is_string($request->input('password'))) {
        return false;
    }

    $user = User::where('email', $request->input('email'))->first();

    // Check if the user exists and if their password matches.
    return $user && bcrypt($request->input('password')) === $user->password;
}
```

## Token Generation

Once we have validated the login request, we can generate a token for the user using our custom `LoginService` class.

```php
// app/services/LoginService.php (continued)

public function generateToken(User $user)
{
    // Generate a new token.
    $token = str_random(60);

    // Store the token in the database.
    $user->token = $token;
    $user->save();

    return $token;
}
```

This example demonstrates a basic authentication flow using Eloquent and Laravel's built-in services. However, you can customize and extend this to fit your specific use case.