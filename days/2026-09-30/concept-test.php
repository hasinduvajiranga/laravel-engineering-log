<?php

use App\Queries\CrossDatabaseQuery;
use Illuminate\Support\Facades\DB;

class CrossDatabaseQueryTest extends TestCase
{
    public function test_get_users_from_primary()
    {
        $query = new CrossDatabaseQuery;

        $primaryDBConnection = DB::connection('primary');
        $secondaryDBConnection = DB::connection('secondary');

        $primaryDBUsers = $primaryDBConnection->table('users')->get();
        $secondaryDBUsers = $secondaryDBConnection->table('users')->get();

        self::assertEquals(count($primaryDBUsers), count($secondaryDBUsers));
    }

    public function test_get_users_from_secondary()
    {
        $query = new CrossDatabaseQuery;

        $primaryDBConnection = DB::connection('primary');
        $secondaryDBConnection = DB::connection('secondary');

        $primaryDBUsers = $primaryDBConnection->table('users')->get();
        $secondaryDBUsers = $secondaryDBConnection->table('users')->get();

        self::assertEquals(count($primaryDBUsers), count($secondaryDBUsers));
    }

    public function test_get_different_data_from_both_databases()
    {
        $query = new CrossDatabaseQuery;

        $primaryDBConnection = DB::connection('primary');
        $secondaryDBConnection = DB::connection('secondary');

        $primaryDBUsers = $primaryDBConnection->table('users')->get();
        $secondaryDBUsers = $secondaryDBConnection->table('users')->get();

        self::assertNotEquals($primaryDBUsers, $secondaryDBUsers);
    }
}
