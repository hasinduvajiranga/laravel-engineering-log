// File: app/Models/Searchable.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class Searchable extends Model
{
    protected $fillable = [
        'title',
        'description',
        'content'
    ];

    public function fullTextSearch(Builder $builder)
    {
        return $builder->where(function ($query) {
            $query->where('title', 'like', '%' . $this->title . '%')
                 ->orWhere('description', 'like', '%' . $this->title . '%')
                 ->orWhere('content', 'like', '%' . $this->title . '%');
        });
    }
}