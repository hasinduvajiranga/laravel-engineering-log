// File: tests/Http/Controllers/PaginationControllerTest.php

namespace Tests\Http\Controllers;

use App\Http\Controllers\PaginationController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PaginationControllerTest extends TestCase
{
    use RefreshDatabase, DatabaseMigrations, DatabaseTransactions;

    public function testLengthAwarePaginatorWorks()
    {
        $users = factory(App\Models\User::class, 25)->create();

        $response = $this->getJson(route('pagination.index'));

        $response->assertJson([
            'data' => [
                // 10 items per page
                ['id', 'name', 'email'],
                ['id', 'name', 'email'],
                ['id', 'name', 'email'],
                ['id', 'name', 'email'],
                ['id', 'name', 'email'],
                ['id', 'name', 'email'],
                ['id', 'name', 'email'],
                ['id', 'name', 'email'],
                ['id', 'name', 'email'],
                ['id', 'name', 'email'],
            ],
            // Total pages for 25 users and 10 items per page
            'total' => 3,
        ]);
    }
}