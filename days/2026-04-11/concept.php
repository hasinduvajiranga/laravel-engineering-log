// Define a custom rule for Pint that checks if the namespace is properly f
formatted
namespace Prettus\Laravel\Pint\Rules;

use Prettus\Laravel\Pint\Rule;
use Prettus\Laravel\Pint\Exception;
use Prettus\Laravel\Pint\Pint;

class NamespaceRule extends Rule
{
    /**
     * @var string
     */
    protected $pattern = '/^[a-zA-Z_][a-zA-Z0-9_]*/';

    public function apply(Pint $pint): void
    {
        foreach ($pint->getNamespaceNames() as $namespace) {
            if (!preg_match($this->pattern, $namespace)) {
                throw new Exception("Invalid namespace: $namespace");
            }
        }
    }
}