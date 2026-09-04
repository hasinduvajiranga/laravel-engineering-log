// File: app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class User extends Model
{
    protected $fillable = ['name', 'email'];

    // Define the spatial column
    public $spatialColumn = 'geometry';

    // Define a method to perform an Eloquent Spatial Query
    public function byLocation($lat, $lng)
    {
        return self::whereRaw("ST_DWithin(geometry, ST_GeomFromText('POINT({$lng} {$lat})'), 1000)") ->get();
    }
}