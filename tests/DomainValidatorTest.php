<?php

namespace rugabarbo\DomainValidator\Test;

use PHPUnit\Framework\TestCase;
use rugabarbo\DomainValidator\DomainValidator;

final class DomainValidatorTest extends TestCase
{
    public function defaultProvider(): array
    {
        return [
            // Regular domains are OK
            ['google.com', true],
            ['news.google.co.uk', true],

            // Local domains disabled by default
            ['a', false],
            ['0', false],
            ['a.b', false],
            ['localhost', false],

            // Punycode domains disabled by default
            ['xn--fsqu00a.xn--0zwm56d', false],

            // Wrong domains
            ['goo gle.com', false],
            ['google..com', false],
            ['google.com ', false],
            ['google-.com', false],
            ['.google.com', false],
            ['<script', false],
            ['alert(', false],
            ['.', false],
            ['..', false],
            [' ', false],
            ['-', false],
            ['', false],
        ];
    }

    /**
     * @dataProvider defaultProvider
     * @param string $value
     * @param bool $isValid
     */
    public function testDefault(string $value, bool $isValid): void
    {
        $validator = new DomainValidator();
        $this->assertEquals($isValid, $validator->isValid($value));
    }
}
