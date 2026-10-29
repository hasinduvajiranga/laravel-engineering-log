# Eloquent API Token Management

This example demonstrates how to manage API tokens using Eloquent in Laravel. We'll create two models, `User` and `ApiToken`, to store user data and API tokens respectively.

### User Model

The `User` model includes an `apiTokens()` method that returns a relationship with the `ApiToken` model. This allows us to easily access and manage a user's API tokens.

```php
class User extends Model
{
    use HasFactory, MacAddressable;

    protected $fillable = [
        'name',
        'email',
        'mac_address',
        'api_token'
    ];

    public function apiTokens()
    {
        return $this->hasMany(ApiToken::class);
    }
}
```

### ApiToken Model

The `ApiToken` model includes an `authorizable()` method that allows us to use it as an authorizer for API requests. We'll also define a relationship with the `User` model.

```php
class ApiToken extends Model
{
    use Authorizable;

    protected $fillable = [
        'token',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
```

### Managing API Tokens

To manage API tokens, we'll create a `User` model method called `generateApiToken()`. This method will generate a new random API token and store it in the database.

```php
public function generateApiToken()
{
    $token = str_random(32);
    $this->apiTokens()->create(['token' => $token]);
}
```

We'll also create an `User` model method called `attemptApiToken()` that takes an API token as input and attempts to authenticate the user using it.

```php
public function attemptApiToken($token)
{
    return $this->authManager()->user($token);
}
```

### Testing API Token Management

To test our API token management, we'll create a `UserTest` class that includes two tests:

*   `testUserCanGenerateApiToken()`: This test creates a new user and generates an API token for them. It then asserts that the user has one API token in their database.
*   `testUserCanUseApiToken()`: This test creates a new user, generates an API token for them, and then attempts to authenticate using the API token.

```php
public function testUserCanGenerateApiToken()
{
    $user = new User();
    $user->name = 'John Doe';
    $user->email = 'john@example.com';

    // Generate an API token for the user
    $token = str_random(32);

    // Update the user's API tokens array with the generated token
    $user->apiTokens()->create(['token' => $token]);

    // Assert that the user has one API token
    $this->assertCount(1, $user->apiTokens());
}

public function testUserCanUseApiToken()
{
    $user = new User();
    $user->name = 'Jane Doe';
    $user->email = 'jane@example.com';

    // Generate an API token for the user
    $token = str_random(32);

    // Update the user's API tokens array with the generated token
    $user->apiTokens()->create(['token' => $token]);

    // Assert that the user can use the API token to authenticate
    $this->assertTrue($user->attemptApiToken($token));
}
```

These tests demonstrate how you can manage API tokens using Eloquent in Laravel, including generating and authenticating users with their API tokens.