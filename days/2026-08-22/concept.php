// Define a trait for custom scoping
namespace App\Traits;

trait EloquentModelScoper
{
    /**
     * Scope the query to only include records where the column is within the given range.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $column
     * @param  int  $min
     * @param  int  $max
     * @return void
     */
    public function scopeWithinRange($query, $column, $min, $max)
    {
        return $query->whereBetween($column, [$min, $max]);
    }
}

// Define a user model that uses the custom scoping trait
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\EloquentModelScoper;

class User extends Model
{
    use EloquentModelScoper;

    /**
     * Get the relationship between the model and its users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Scope the query to only include records where the post's creation date is within a given range.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $minDate
     * @param  int  $maxDate
     * @return void
     */
    public function scopeByPostCreated($query, $minDate, $maxDate)
    {
        return $this->posts()->whereBetween('created_at', [$minDate, $maxDate])->get();
    }
}