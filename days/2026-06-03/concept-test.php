// Test for route pattern constraints using Pest
use Pest\Laravel\Pest\LaravelTest;
use Illuminate\Support\Facades\Route;

test('route pattern constraints', function (LaravelTest $test) {
    // Act
    Route::post('/users/123/posts', function ($request, $user_id = 123) {
        // Verify the route is called with the correct user ID
        $this->assertEquals(123, $request->input('user_id'));
    });

    // Test for invalid input (non-integer user ID)
    Route::post('/users/non-integer/posts', function ($request, $user_id = 'non-integer') {
        // Verify the route is not called
        $this->assertNull($request->input('user_id'));
    });
});