use Pest\Laravel\Feature;
use Tests\TestCase;

class EloquentExcelIntegrationTest extends TestCase
{
    public function test_usersExport()
    {
        $user = factory(User::class)->create(['name' => 'John Doe', 'email' => 'john@example.com']);
        
        $this->assertEquals(1, count(Storage::allFiles('exports/users.xlsx')));
        Storage::deleteFile(public_path('exports/users.xlsx'));
    }

    public function test_ordersExport()
    {
        factory(Order::class)->create(['user_id' => 1, 'product_id' => 1, 'quantity' => 10]);
        
        $this->assertEquals(1, count(Storage::allFiles('exports/orders.xlsx')));
        Storage::deleteFile(public_path('exports/orders.xlsx'));
    }
}