// tests/Unit/Alerts/RulesTest.php

namespace Tests\Unit\Alerts;

use App\Alerts\Models\Rule;
use App\Alerts\Models\RuleCondition;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use PHPUnit\Framework\TestCase;

class RulesTest extends TestCase
{
    use DatabaseMigrations;

    public function testGetRulesForAlert()
    {
        $rule1 = new Rule();
        $rule1->name = 'Rule 1';
        $rule1->description = 'This is rule 1';
        $rule1->alert_type = 'email';
        $rule1->threshold = 10;
        $rule1->rules()->create(['condition_type' => 'less_than', 'value' => 5]);
        $rule1->save();

        $rule2 = new Rule();
        $rule2->name = 'Rule 2';
        $rule2->description = 'This is rule 2';
        $rule2->alert_type = 'sms';
        $rule2->threshold = 20;
        $rule2->rules()->create(['condition_type' => 'greater_than', 'value' => 15]);
        $rule2->save();

        $result = Rules::getRulesForAlert('email');
        $this->assertCount(1, $result);
        $this->assertEquals($rule1->name, $result[0]->name);

        $result = Rules::getRulesForAlert('sms');
        $this->assertCount(1, $result);
        $this->assertEquals($rule2->name, $result[0]->name);
    }
}