<?php

declare(strict_types=1);

namespace Ntzm\IsokTest;

use Ntzm\Isok\Path;
use Ntzm\Isok\Rule\Rule;
use Ntzm\Isok\ValidationResult;
use Ntzm\Isok\Violation\Violation;
use Ntzm\Isok\Violation\Violations;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Ntzm\Isok\ValidationResult
 */
final class ValidationResultTest extends TestCase
{
    public function testPasses() : void
    {
        $result = $this->passedValidationResult();

        self::assertTrue($result->passes());
    }

    public function testDoesNotPass() : void
    {
        $result = $this->failedValidationResult();

        self::assertFalse($result->passes());
    }

    public function testFails() : void
    {
        $result = $this->failedValidationResult();

        self::assertTrue($result->fails());
    }

    public function testDoesNotFail() : void
    {
        $result = $this->passedValidationResult();

        self::assertFalse($result->fails());
    }

    public function testViolations() : void
    {
        $violations = Violations::none();

        $result = new ValidationResult($violations);

        self::assertSame($violations, $result->violations());
    }

    private function fakeRule() : Rule
    {
        return new class implements Rule {
            public function violationsFor($value, Path $path) : Violations
            {
                return Violations::none();
            }
        };
    }

    private function passedValidationResult() : ValidationResult
    {
        return new ValidationResult(Violations::none());
    }

    private function failedValidationResult() : ValidationResult
    {
        return new ValidationResult(new Violations(new Violation('foo', $this->fakeRule(), Path::root())));
    }
}
