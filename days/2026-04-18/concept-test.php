// tests/Http/Resources/UserResourceTest.php

namespace Tests\Http\Resources;

use App\Http\Resources\UserResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestEnabled;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\TestCase;
use Mockery;

class UserResourceTest extends TestCase
{
    use RefreshDatabase, TestEnabled;

    public function testUserResourceTransformsCorrectly()
    {
        $user = factory(User::class)->create();
        $resource = new UserResource($user);
        $expectedResponse = [
            'id' => 1,
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
        ];

        $this->assertEquals($expectedResponse, (array) $resource);
    }
}

// tests/Http/Resources/ProductResourceTest.php

namespace Tests\Http\Resources;

use App\Http\Resources\ProductResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestEnabled;
use Illuminate\Http\Request;
use Mockery;

class ProductResourceTest extends TestCase
{
    use RefreshDatabase, TestEnabled;

    public function testProductResourceTransformsCorrectly()
    {
        $product = factory(Product::class)->create();
        $resource = new ProductResource($product);
        $expectedResponse = [
            'id' => 1,
            'name' => 'Apple iPhone',
            'price' => 999.99,
        ];

        $this->assertEquals($expectedResponse, (array) $resource);
    }
}