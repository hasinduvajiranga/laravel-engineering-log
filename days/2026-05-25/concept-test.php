// File: tests/Feature/ApplicationRouteGroupPrefixingTest.php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithApplicationEvents;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class ApplicationRouteGroupPrefixingTest extends TestCase
{
    use DatabaseMigrations, WithApplicationEvents, WithoutMiddleware;

    /**
     * Test that the route group prefix is applied correctly.
     *
     * @return void
     */
    public function testRouteGroupPrefixIsAppliedCorrectly()
    {
        // Test that the 'api' prefix routes are under the correct namespace
        $this->assertRouteExists('GET:api/users');

        // Test that the 'admin' prefix routes are under the correct namespace
        $this->assertRouteExists('GET:admin/dashboard');
    }

    /**
     * Test that route group prefixing works correctly with nested namespaces.
     *
     * @return void
     */
    public function testNestedNamespace()
    {
        // Test that the 'api/users' and 'admin/dashboard' routes are under the correct namespace
        $this->assertRouteExists('GET:api/users');
        $this->assertRouteExists('GET:admin/dashboard');

        // Test that the nested namespaces work correctly
        $this->assertRouteExists('POST:api/users/1');
        $this->assertRouteExists('PUT:admin/dashboard/1');
    }
}