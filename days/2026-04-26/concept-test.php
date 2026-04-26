// Test the polymorphic relationships
namespace Tests\Feature;

use App\Models\ConcreteEntity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Tests\TestCase;

class PolymorphicRelationshipsTest extends TestCase
{
    use RefreshDatabase;

    public function test_polymorphic_relationships()
    {
        // Create instances of the concrete entity and its related data
        $entity = ConcreteEntity::factory()->create();
        $relatedData1 = RelatedData::factory()->create(['entity_id' => $ent
$entity->id]);
        $relatedData2 = RelatedData::factory()->create(['entity_id' => $ent
$entity->id]);

        // Test the many-to-many relationship
        $many_to_many_relation = $entity->many_to_many_relationship();
        $this->assertCount(2, $many_to_many_relation);

        // Test the one-to-one relationship
        $one_to_one_relation = $entity->one_to_one_relationship();
        $this->assertEquals($relatedData1->id, $one_to_one_relation->id);
    }
}