// Test case for polymorphic relationships
namespace Tests\Feature\Models;

use App\Models\ChildModel;
use App\Models\ParentModel;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestEnabled;
use Illuminate\Foundation\Testing\WithoutMigrations;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PolymorphicRelationshipsTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase, TestEnabled, WithoutMigrations
WithoutMigrations;

    public function test_polymorphic_relationships()
    {
        // Create a parent model and save it to the database
        $parent = new ParentModel();
        $parent->name = 'Parent Model';
        $parent->save();

        // Create two child models that are related to the same parent mode
model
        $child1 = new ChildModel();
        $child1->name = 'Child 1';
        $child1->parent_id = $parent->id;
        $child1->save();

        $child2 = new ChildModel();
        $child2->name = 'Child 2';
        $child2->parent_id = $parent->id;
        $child2->save();

        // Test that the parent model's children relationship returns both 
child models
        foreach ($parent->children as $child) {
            $this->assertEquals($child->name, 'Child 1');
            $this->assertEquals($child->name, 'Child 2');
        }

        // Test that the child model's parents relationship returns the par
parent model
        foreach ($child1->parents as $parent) {
            $this->assertEquals($parent->name, 'Parent Model');
        }
    }
}