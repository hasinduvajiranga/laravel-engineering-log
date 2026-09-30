<?php

namespace App\Queries;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CrossDatabaseQuery extends Model
{
    /**
     * Get all users from the primary database
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUsersFromPrimary()
    {
        return $this->primaryDatabase()->users();
    }

    /**
     * Get all users from the secondary database
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUsersFromSecondary()
    {
        return $this->secondaryDatabase()->users();
    }
}

class PrimaryDatabase
{
    public static function getPrimaryConnection()
    {
        return DB::connection('primary');
    }

    public function users()
    {
        return self::getPrimaryConnection()->table('users')->get();
    }
}

class SecondaryDatabase
{
    public static function getSecondaryConnection()
    {
        return DB::connection('secondary');
    }

    public function users()
    {
        return self::getSecondaryConnection()->table('users')->get();
    }
}