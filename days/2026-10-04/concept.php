// EloquentSlowQueryDetector.php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class EloquentSlowQueryDetector extends Model
{
    protected $table = 'slow_queries';

    public function __construct()
    {
        parent::__construct();
        $this->timestamps = false;
    }

    // Define a query that will trigger slow query detection
    public function getSlowQueries($limit = 10)
    {
        return $this->query()->where('duration', '>', 100)->limit($limit)->get();
    }
}