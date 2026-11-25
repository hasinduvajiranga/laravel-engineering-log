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