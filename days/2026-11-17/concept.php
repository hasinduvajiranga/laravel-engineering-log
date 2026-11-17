// File: app/Models/Error.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Error extends Model
{
    use HasFactory;

    protected $fillable = ['message', 'code', 'stack_trace'];

    public function errors()
    {
        return $this->hasMany(ErrorDetail::class, 'error_id');
    }
}

// File: app/Models/ErrorDetail.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ErrorDetail extends Model
{
    use HasFactory;

    protected $fillable = ['error_id', 'detail'];

    public function error()
    {
        return $this->belongsTo(Error::class, 'error_id');
    }
}