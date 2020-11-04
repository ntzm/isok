<?php

declare(strict_types=1);

namespace Ntzm\Isok\Translator;

use Ntzm\Isok\Rule;
use Ntzm\Isok\Violation\Violation;

use function array_key_exists;
use function get_class;

final class EnglishTranslator implements Translator
{
    private const TRANSLATIONS = [
        Rule\Arr\HasKey::class => ':name must have a key named :key',
        Rule\Arr\IsArray::class => ':name must be an array',
        Rule\Arr\IsSubsetOf::class => ':name must be a subset of :allowedValues',
        Rule\Bool\IsBool::class => ':name must be a boolean',
        Rule\Bool\IsFalse::class => ':name must be false',
        Rule\Bool\IsTrue::class => ':name must be true',
        Rule\DateTime\IsDateTime::class => ':name must be a valid date and time',
        Rule\Length\HasExactLength::class => ':name must have a length of :length',
        Rule\Length\HasLengthBetween::class => ':name must have a length between :min and :max',
        Rule\Length\HasMaximumLength::class => ':name must have a maximum length of :max',
        Rule\Length\HasMinimumLength::class => ':name must have a minimum length of :max',
        Rule\Net\IsEmailAddress::class => ':name must be an email address',
        Rule\Net\IsIPAddress::class => ':name must be an IP address',
        Rule\Net\IsIPv4Address::class => ':name must be an IPv4 address',
        Rule\Net\IsIPv6Address::class => ':name must be an IPv6 address',
        Rule\Net\IsMacAddress::class => ':name must be a MAC address',
        Rule\Net\IsUrl::class => ':name must be a URL',
        Rule\Number\IsFloat::class => ':name must be a floating point number',
        Rule\Number\IsInt::class => ':name must be an integer',
        Rule\Object\IsInstanceOf::class => ':name must be an instance of :class',
        Rule\String\EndsWith::class => ':name must end with :needle',
        Rule\String\IsString::class => ':name must be a string',
        Rule\String\MatchesRegex::class => ':name must match pattern :pattern',
        Rule\String\StartsWith::class => ':name must start with :needle',
        Rule\UUID\IsUUID::class => ':name must be a UUID',
        Rule\UUID\IsUUIDv1::class => ':name must be a UUIDv1',
        Rule\UUID\IsUUIDv2::class => ':name must be a UUIDv2',
        Rule\UUID\IsUUIDv3::class => ':name must be a UUIDv3',
        Rule\UUID\IsUUIDv4::class => ':name must be a UUIDv4',
        Rule\UUID\IsUUIDv5::class => ':name must be a UUIDv5',
        Rule\Is::class => ':name must be :expectedValue',
    ];

    public function translate(Violation $violation): string
    {
        $rule = get_class($violation->rule());

        if (! array_key_exists($rule, self::TRANSLATIONS)) {
            return $rule . ' violation';
        }

        $message = self::TRANSLATIONS[$rule];
    }
}
