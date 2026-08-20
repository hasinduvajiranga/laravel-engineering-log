// models/User.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class User extends Model
{
    protected $fillable = ['name', 'email'];

    public function getUsers()
    {
        return DB::table('users')->where('created_at', '<', now()->subMinutes(10))->get();
    }

    public function getAllUsers()
    {
        return DB::table('users')->all();
    }
}