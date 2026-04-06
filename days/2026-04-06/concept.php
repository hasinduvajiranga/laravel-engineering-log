// Define the BaseModel class that will be used for polymorphic relationshi
relationships
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class BaseModel extends Model
{
    // Create a morphMany relationship with the BaseModel that will store f
foreign keys to other models
    public function children(): MorphMany
    {
        return $this->morphMany(BaseModel::class, 'child');
    }
}

// Define the ParentModel class that will be used as the parent model in th
the polymorphic relationship
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class ParentModel extends BaseModel
{
    // Create a morphOne relationship with another model in the polymorphic
polymorphic relationship chain
    public function child(): MorphOne
    {
        return $this->morphOne(ParentModel::class, 'parent');
    }
}

// Define the ChildModel class that will be used as the child model in the 
polymorphic relationship
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ChildModel extends BaseModel
{
    // Create a morphMany relationship with the ParentModel that will store
store foreign keys to other models
    public function parents(): MorphMany
    {
        return $this->morphMany(ParentModel::class, 'parent');
    }
}