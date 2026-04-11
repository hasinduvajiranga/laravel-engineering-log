use Pest\Laravel\Tests\TestCase;
use Prettus\Laravel\Pint\Rules\NamespaceRule;

class PintTest extends TestCase
{
    public function testNamespaceRule()
    {
        // Create a custom rule instance
        $namespaceRule = new NamespaceRule();

        // Define some invalid namespace names
        $invalidNamespaces = [
            'foo',
            'bar-',
            'baz!',
        ];

        // Test that the rule throws an exception for each invalid namespac
namespace
        foreach ($invalidNamespaces as $namespace) {
            $this->expectException(Exception::class);
            $namespaceRule->apply(new Pint());
        }
    }

    public function testNamespaceRulePassesValidNamespace()
    {
        // Create a custom rule instance
        $namespaceRule = new NamespaceRule();

        // Define some valid namespace names
        $validNamespaces = [
            'Prettus\Laravel\Pint',
            'Foo\Bar\Baz',
        ];

        // Test that the rule passes for each valid namespace
        foreach ($validNamespaces as $namespace) {
            $this->notThrowableException(Exception::class);
            $namespaceRule->apply(new Pint());
        }
    }
}