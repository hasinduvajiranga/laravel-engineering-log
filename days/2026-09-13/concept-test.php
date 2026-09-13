// tests/Models/UserTest.php

namespace Tests\Models;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testUsersCanBePaginated()
    {
        $users = factory(User::class, 10)->create();

        // Retrieve the first page of paginated users (15 users per page)
        $page1 = UsersPagination::make($users);

        // Assert that we get 15 users in the collection
        $this->assertCount(15, $page1->items);
    }

    public function testGetNextPage()
    {
        // Create an initial set of users (10) and a second set of users to be appended to the first page
        $users = factory(User::class, 5)->create();
        $existingUsers = User::all();

        $page1 = UsersPagination::make($existingUsers);

        // Retrieve the next page of paginated users
        $nextPage = $page1->getNext();

        // Append the new set of users to the first page
        $newUsers = collect($users)->merge(collect($existingUsers));
        $newPage = UsersPagination::make($newUsers);

        // Assert that we get 15 users in the collection (the two sets were appended)
        $this->assertCount(20, $newPage->items);
    }

    public function testGetPreviousPage()
    {
        // Create an initial set of users (10) and a second set of users to be prepended to the last page
        $users = factory(User::class, 5)->create();
        $existingUsers = User::all();

        $lastPage = UsersPagination::make($existingUsers);

        // Retrieve the previous page of paginated users
        $prevPage = $lastPage->getPrevious();

        // Prepend the new set of users to the last page
        $newUsers = collect($users)->merge(collect($existingUsers));
        $newLastPage = UsersPagination::make($newUsers);

        // Assert that we get 15 users in the collection (the two sets were prepended)
        $this->assertCount(20, $newLastPage->items);
    }
}