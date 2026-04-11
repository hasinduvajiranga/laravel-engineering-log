// src/Conventions/LintingRules.php

namespace App\Conventions;

use Pint\LintingRules\AbstractRule;
use Pint\Linter\Linter;

class TrailingWhitespaceRule extends AbstractRule
{
    protected $message = 'Trailing whitespace is not allowed';

    public function appliesTo(): string
    {
        return Linter::TRAILING_WHITESPACE;
    }

    public function process(Linter $linter, string $code): void
    {
        if ($this->apply($linter, $code)) {
            $linter->error($this->message);
        }
    }

    private function apply(Linter $linter, string $code): bool
    {
        return trim($code) !== $code;
    }
}