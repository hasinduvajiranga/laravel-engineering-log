namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
    ];

    public function createIdempotentUser($inputData)
    {
        // Eager loading to reduce database queries
        $existingUser = self::where('email', $inputData['email'])->first();

        if ($existingUser) {
            // Update the user if it already exists
            return $this->update($inputData);
        } else {
            // Create a new user
            return $this->create($inputData);
        }
    }

    public function update($data)
    {
        // Use Eloquent's built-in update method to ensure idempotency
        $updatedUser = $this->find($data['id'])->update($data);

        if (!$updatedUser) {
            throw new \Exception('Failed to update user');
        }

        return $updatedUser;
    }
}