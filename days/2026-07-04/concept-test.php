// tests/Http/ControllerTest.php

namespace Tests\Http\Controllers;

use Tests\TestCase;
use App\Http\ControllersHomeController;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HomeControllerTest extends TestCase
{
    use WithFaker, WithoutMiddleware, DatabaseMigrations, DatabaseTransactions;

    public function test_index_view_is_returned()
    {
        // Create a new instance of the HomeController.
        $controller = new HomeController();

        // Test that the index view is returned when theHomeController's index method is called.
        $response = $this->actingAs($controller)->get(route('home'));
        $response->assertViewIs('home');
    }

    public function test_prices_are_retrieved_correctly()
    {
        // Create a new instance of the HomeController and set up mock prices in the database.
        $controller = new HomeController();
        $precioMock = factory(App\Models\Precio::class)->create(['valor' => '10.00']);
        $controller->precio = Precio::find($precioMock->id);

        // Test that the price value is returned correctly when theHomeController's index method is called.
        $response = $this->actingAs($controller)->get(route('home'));
        $response->assertViewHas('precio', ['valor' => '10.00']);
    }
}