// File: app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['name', 'email'];

    // Define a global scope to filter users by their role
    public function scopeAdminUsers($query)
    {
        return $query->where('role', 'admin');
    }

    // Define another global scope to filter users by their department
    public function scopeDepartmentUsers($query, $departmentId)
    {
        return $query->where('department_id', $departmentId);
    }
}