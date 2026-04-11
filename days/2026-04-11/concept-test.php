// tests/Conventions/LintingRulesTest.php

namespace App\tests\Conventions;

use Pint\Linter\Linter;
use PHPUnit\Framework\TestCase;
use App\Conventions\LintingRules\TrailingWhitespaceRule;

class TrailingWhitespaceRuleTest extends TestCase
{
    public function testAppliesTo(): void
    {
        $linter = new Linter(new TrailingWhitespaceRule());
        $this->assertTrue($linter->appliesTo(Linter::TRAILING_WHITESPACE));
$this->assertTrue($linter->appliesTo(Linter::TRAILING_WHITESPACE));
    }

    public function testProcess(): void
    {
        $linter = new Linter(new TrailingWhitespaceRule());
        $code = 'This is a line of code';
        $linter->process($code);

        $this->assertContains($linter->getMessage(), $linter->getMessages()
$linter->getMessages());

        $newCode = trim($code);
        $newLinter = new Linter(new TrailingWhitespaceRule());
        $newLinter->process($newCode);

        $this->assertFalse($newLinter->hasError($linter->getMessage()));
    }
}