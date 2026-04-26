// Define a base class for entities that can have many relationships with d
different types of data
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class Entity extends Model
{
    // Use polymorphism to handle different relationship types
    public function getRelatedData()
    {
        $relatedData = [];

        if ($this->hasManyRelationship()) {
            $relatedData['many_to_many'] = $this->hasManyRelationship();
        }

        if ($this->hasOneRelationship()) {
            $relatedData['one_to_one'] = $this->hasOneRelationship();
        }

        if ($this->belongsToManyRelationship()) {
            $relatedData['many_to_many'] = $this->belongsToManyRelationship
$this->belongsToManyRelationship();
        }

        return $relatedData;
    }

    // Check if the entity has a many-to-many relationship
    protected function hasManyRelationship()
    {
        return $this->relationExists('hasMany');
    }

    // Get the many-to-many relationship instance
    protected function hasManyRelationshipInstance()
    {
        return $this->hasMany('App\Models\RelatedData', 'entity_id');
    }

    // Check if the entity has a one-to-one relationship
    protected function hasOneRelationship()
    {
        return $this->relationExists('hasOne');
    }

    // Get the one-to-one relationship instance
    protected function hasOneRelationshipInstance()
    {
        return $this->hasOne('App\Models\RelatedData', 'entity_id');
    }

    // Check if the entity has a many-to-many relationship
    protected function belongsToManyRelationship()
    {
        return $this->relationExists('belongsToMany');
    }

    // Get the many-to-many relationship instance
    protected function belongsToManyRelationshipInstance()
    {
        return $this->belongsToMany('App\Models\RelatedData', 'entity_id', 
'related_data_id');
    }
}

// Define a concrete class that extends the base Entity class
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Entity;

class ConcreteEntity extends Entity
{
    public function many_to_many_relationship()
    {
        return $this->hasManyRelationshipInstance()->collect();
    }

    public function one_to_one_relationship()
    {
        return $this->hasOneRelationshipInstance();
    }
}