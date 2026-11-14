// tests/Http/Libraries/EloquentApiHealthCheckTest.php

namespace Tests\Http\Libraries;

use App\Http\Libraries\EloquentApiHealthCheck;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Pest\Laravel\FeatureTestCase;
use Pest\Laravel\Support\Request;
use Pest\Laravel\Support\Response;

class EloquentApiHealthCheckTest extends FeatureTestCase
{
    use RefreshDatabase;

    public function testRun(): void
    {
        $this->app->bind('EloquentApiHealthCheck', new EloquentApiHealthCheck());

        $request = Request::make('GET', '/api/health');
        $response = $this->app['http']->get($request);

        $response->assertOk();
        $response->assertJson([
            'status' => 'ok',
            'message' => '',
            'errors' => [],
        ]);
    }

    public function testRunNoDatabaseConnection(): void
    {
        \DB::disconnect();

        $this->app['EloquentApiHealthCheck'] = new EloquentApiHealthCheck();
        $response = $this->app['http']->get('/api/health');

        $response->assertOk();
        $response->assertJson([
            'status' => 'ok',
            'message' => 'Database connection failed',
            'errors' => ['Database error: Connection is not established'],
        ]);
    }

    public function testRunModelClassesNotLoaded(): void
    {
        \App\Models\User::forget();

        $this->app['EloquentApiHealthCheck'] = new EloquentApiHealthCheck();
        $response = $this->app['http']->get('/api/health');

        $response->assertOk();
        $response->assertJson([
            'status' => 'ok',
            'message' => 'Model classes not loaded',
            'errors' => ['Model class error: Class App\Models\User is not defined'],
        ]);
    }

    public function testRunRelationshipsNotLoaded(): void
    {
        \App\Models\User::forget();
        $user = factory(\App\Models\User::class)->create();

        // Delete relationship
        $user->address()->delete();

        $this->app['EloquentApiHealthCheck'] = new EloquentApiHealthCheck();
        $response = $this->app['http']->get('/api/health');

        $response->assertOk();
        $response->assertJson([
            'status' => 'ok',
            'message' => 'Relationships not loaded',
            'errors' => ['Relationship error: Relationship App\Models\User(address) is not defined'],
        ]);
    }

    public function testRunCacheNotAvailable(): void
    {
        \Cache::forget('test');

        $this->app['EloquentApiHealthCheck'] = new EloquentApiHealthCheck();
        $response = $this->app['http']->get('/api/health');

        $response->assertOk();
        $response->assertJson([
            'status' => 'ok',
            'message' => 'Cache not available',
            'errors' => ['Cache error: Cache item test is not available'],
        ]);
    }
}