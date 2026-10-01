// File: app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Connection;

class User extends Model
{
    protected $connection = 'mysql';

    public function getReadConnection()
    {
        return Connection::get('mysql');
    }

    public function getWriteConnection()
    {
        return Connection::get('mysql', true);
    }
}