// File: tests/Http/RedirectControllerTest.php

namespace Tests\Http;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestSuite;
use Laravel\DuskTestCase;
use App\Http\Controllers\RedirectController;
use Tests\TestCase;

class RedirectControllerTest extends TestCase
{
    use RefreshDatabase, DuskTestCase;

    protected $controller;

    public function setUp(): void
    {
        parent::setUp();

        $this->controller = new RedirectController();
    }

    /**
     * Test the custom redirect response is returned correctly.
     */
    public function testShowCustomRedirect()
    {
        $response = $this->get(route('redirect.show', ['url' => 'https://example.com']));

        $response->assertSee('Redirect Response');
        $response->assertRedirect('https://example.com');
    }

    /**
     * Test the custom redirect response with query parameters.
     */
    public function testShowCustomRedirectWithQueryParams()
    {
        $response = $this->get(route('redirect.show', ['url' => 'https://example.com?param=value']));

        $response->assertSee('Redirect Response');
        $response->assertRedirect('https://example.com?param=value');
    }
}