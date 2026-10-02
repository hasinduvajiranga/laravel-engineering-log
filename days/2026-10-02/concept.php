// models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class User extends Model
{
    protected $connection = 'mysql';
    public $incrementing = false;
    protected $primaryKey = 'id';

    // Use the connection pool for database queries
    public function boot()
    {
        parent::boot();

        // Set up Eloquent's connection pool
        DB::reconnect();
    }
}