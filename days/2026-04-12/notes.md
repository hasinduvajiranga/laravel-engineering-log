# Laravel Sanctum Authentication

Laravel Sanctum is a package that provides a simple and secure way to authe
authenticate users using JSON Web Tokens (JWT). It's built on top of Larave
Laravel's built-in authentication system.

Here's an overview of how it works:

1.  **User Authentication**: When a user logs in, they receive a JWT token 
which contains their user data.
2.  **Token Validation**: On subsequent requests, the client sends the toke
token along with the request.
3.  **Authorization**: The server validates the token using Laravel's built
built-in authentication system.

Key Features:

*   **JSON Web Tokens (JWT)**: Sanctum uses JWT tokens to store and verify 
user data.
*   **Cookie-based Token Storage**: Sanctum can be used with cookies for cl
client-side storage, or with a more secure option of storing the token in l
local storage.
*   **Server-side Validation**: Laravel provides built-in validation mechan
mechanisms to ensure only authorized users access protected resources.

To implement this system:

1.  Install Laravel Sanctum using Composer: `composer require laravel/sanct
laravel/sanctum`
2.  Create an API key and client ID to use for authorization: Run the follo
following commands in your terminal
    ```bash
php artisan make:seeder ApiKeyTableSeeder
php artisan db:seed --class=ApiKeyTableSeeder
```

    Then, update `config/sanctum.php` to include your generated credentials
credentials:
    ```php
'credentials' => [
    'api_key' => env('SANCTUM_API_KEY'),
],
```
3.  Register a middleware to check for the presence of valid tokens in requ
requests.

The code examples above demonstrate how to create a simple live stream comp
component that authenticates users and checks their authorization before al
allowing access.

Remember, you must always prioritize security when dealing with authenticat
authentication systems like Sanctum. Make sure to handle token validation a
and storage securely to prevent unauthorized access to your resources.