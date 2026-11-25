# Eloquent API Alerting Rules

Eloquent is a powerful ORM in Laravel that provides an elegant syntax for interacting with the database. In this section, we'll explore how to create Eloquent models and relationships to implement alerting rules.

## Rule Model

We'll start by creating a `Rule` model that will store information about each rule, such as its name, description, alert type, and threshold. We'll also define a relationship with the `RuleCondition` model to represent the conditions of each rule.

```php
// app/Alerts/Models/Rule.php

namespace App\Alerts\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rule extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'alert_type',
        'threshold',
    ];

    public function rules()
    {
        return $this->hasMany(RuleCondition::class);
    }
}
```

## Rule Condition Model

Next, we'll create a `RuleCondition` model to represent the conditions of each rule. This model will have relationships with both the `Rule` and `Rule` models.

```php
// app/Alerts\Models/RuleCondition.php

namespace App\Alerts\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RuleCondition extends Model
{
    use HasFactory;

    protected $fillable = [
        'rule_id',
        'condition_type',
        'value',
    ];

    public function rule()
    {
        return $this->belongsTo(Rule::class);
    }
}
```

## Rules Eloquent Model

We'll create a `Rules` model that will store information about all the rules. This model will have relationships with both the `Rule` and `RuleCondition` models.

```php
// app/Alerts/Rules.php

namespace App\Alerts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Rules extends Model
{
    protected $fillable = [
        'name',
        'description',
        'alert_type',
        'threshold',
    ];

    public function rules()
    {
        return $this->hasMany(Rule::class);
    }

    public static function getRulesForAlert($alertType)
    {
        $rules = self::where('alert_type', $alertType)->get();
        return $rules;
    }
}
```

## Testing the Rules Eloquent Model

We'll create a test case to verify that the `getRulesForAlert` method is working correctly. We'll create two rules, one for email alerts and one for SMS alerts, each with different conditions.

```php
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
```

This test case verifies that the `getRulesForAlert` method is working correctly by retrieving rules for email and SMS alerts.