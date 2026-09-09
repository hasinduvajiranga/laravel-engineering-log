// src/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Json;

class User extends Model
{
    protected $fillable = ['name', 'email'];

    public function toArray()
    {
        // Define the serialization format for this model
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            // You can also define custom attributes here
            'is_active' => $this->attributes['status'] === 1 ? true : false,
        ];
    }
}