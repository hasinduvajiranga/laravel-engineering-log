<?php

use App\Queries\CrossDatabaseQuery;
use Illuminate\Support\Facades\DB;

class CrossDatabaseQueryTest extends TestCase
{
    public function testGetUsersFromPrimary()
    {
        $query = new CrossDatabaseQuery();

        $primaryDBConnection = DB::connection('primary');
        $secondaryDBConnection = DB::connection('secondary');

        $primaryDBUsers = $primaryDBConnection->table('users')->get();
        $secondaryDBUsers = $secondaryDBConnection->table('users')->get();

        self::assertEquals(count($primaryDBUsers), count($secondaryDBUsers));
    }

    public function testGetUsersFromSecondary()
    {
        $query = new CrossDatabaseQuery();

        $primaryDBConnection = DB::connection('primary');
        $secondaryDBConnection = DB::connection('secondary');

        $primaryDBUsers = $primaryDBConnection->table('users')->get();
        $secondaryDBUsers = $secondaryDBConnection->table('users')->get();

        self::assertEquals(count($primaryDBUsers), count($secondaryDBUsers));
    }

    public function testGetDifferentDataFromBothDatabases()
    {
        $query = new CrossDatabaseQuery();

        $primaryDBConnection = DB::connection('primary');
        $secondaryDBConnection = DB::connection('secondary');

        $primaryDBUsers = $primaryDBConnection->table('users')->get();
        $secondaryDBUsers = $secondaryDBConnection->table('users')->get();

        self::assertNotEquals($primaryDBUsers, $secondaryDBUsers);
    }
}