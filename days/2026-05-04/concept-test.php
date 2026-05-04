use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AppServiceProviderTest extends TestCase
{
    use RefreshDatabase;

    public function testDisableEloquentLogging()
    {
        // Arrange
        $this->IlluminateContainerHasNotBeenBoundTo('log');

        // Act
        \Illuminate\Support\Facades\Log::disableLogging();

        // Assert
        $this->IlluminateContainerHas BeenBoundTo('log');
    }

    public function testRegisterApiRoutesGroup()
    {
        // Arrange
        $route = Route::group(['middleware' => 'api'], function () {});

        // Act
        $route->register();

        // Assert
        $this->assertIsInstance($route, \Illuminate\Routing\RouteManager::c
\Illuminate\Routing\RouteManager::class);
    }
}