// tests/Unit/test_DomainNavigator.php

namespace Tests\Unit;

use App\Route\DomainNavigator;
use Illuminate\Routing.Navigator;
use PHPUnit\Framework\TestCase;

class test_DomainNavigator extends TestCase
{
    private $navigator;

    public function setUp()
    {
        parent::setUp();
        $this->navigator = new DomainNavigator;
    }

    public function testRegisterRoutes()
    {
        $domains = [
            'admin' => [
                'namespace' => 'App\\Http\\Controllers',
                'routes' => [
                    ['name' => 'dashboard', 'middleware' => [], 'namespace' => '', 'controller' => 'DashboardController', 'action' => 'index'],
                ],
            ],
            'user' => [
                'namespace' => 'App\\Http\\Controllers',
                'routes' => [
                    ['name' => 'profile', 'middleware' => [], 'namespace' => '', 'controller' => 'UserController', 'action' => 'show'],
                ],
            ],
        ];

        $this->navigator->register($domains);
        foreach ($domains as $domain) {
            foreach ($domain['routes'] as $route) {
                $this->navigator->registerRoute($route);
            }
        }

        $this->assertEquals([
            'admin' => [
                'DashboardController@index',
            ],
            'user' => [
                'UserController@show',
            ],
        ], $this->navigator->getRoutes());
    }

    public function testGetDomains()
    {
        $domains = [
            'admin' => [
                'namespace' => 'App\\Http\\Controllers',
                'routes' => [
                    ['name' => 'dashboard', 'middleware' => [], 'namespace' => '', 'controller' => 'DashboardController', 'action' => 'index'],
                ],
            ],
            'user' => [
                'namespace' => 'App\\Http\\Controllers',
                'routes' => [
                    ['name' => 'profile', 'middleware' => [], 'namespace' => '', 'controller' => 'UserController', 'action' => 'show'],
                ],
            ],
        ];

        $this->navigator->getDomains() = $domains;
        foreach ($domains as $domain) {
            foreach ($domain['routes'] as $route) {
                $this->navigator->registerRoute($route);
            }
        }

        $this->assertEquals([
            'admin' => [
                ['name' => 'dashboard', 'middleware' => [], 'namespace' => '', 'controller' => 'DashboardController', 'action' => 'index'],
            ],
            'user' => [
                ['name' => 'profile', 'middleware' => [], 'namespace' => '', 'controller' => 'UserController', 'action' => 'show'],
            ],
        ], $this->navigator->getRoutes());
    }
}