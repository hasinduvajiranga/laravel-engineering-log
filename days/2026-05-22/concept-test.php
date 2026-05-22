// File: tests/RouteMatchers/CustomMatcherTest.php

namespace Tests\Http\RouteMatchers;

use App\Http\RouteMatchers\CustomMatcher;
use Illuminate\Foundation\Http\Router as Router;
use Pest\Laravel\LaravelTests\TestCase;
use Pest\Laravel\Laravel;

class CustomMatcherTest extends TestCase
{
    public function testMatch()
    {
        $matcher = new CustomMatcher();

        $this->assertTrue($matcher->match('/example/url'));

        $this->assertFalse($matcher->match('/another/url'));
    }
}