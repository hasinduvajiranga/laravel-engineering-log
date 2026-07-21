// File: app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Model
{
    use HasFactory;

    protected $casts = [
        'password' => 'hashed',
        'bio' => 'html',
    ];

    public function getBioAttribute($value)
    {
        return html_entity_decode($value);
    }
}