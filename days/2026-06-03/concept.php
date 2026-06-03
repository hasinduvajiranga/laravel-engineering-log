// Define a route pattern with constraints using the Closure syntax
Route::post('/users/{user_id}/posts', function ($request, $user_id) {
    // Check if the user ID is an integer and not zero
    if (!is_int($user_id) || $user_id === 0) {
        abort(400, 'Invalid user ID');
    }
    // Additional logic to handle the request
});