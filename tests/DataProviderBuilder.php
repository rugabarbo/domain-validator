<?php

namespace rugabarbo\DomainValidator\Test;

class DataProviderBuilder
{
    public const ALLOW_PADDINGS = 1;

    public static function getData(int $flags = 0): array
    {
        $flaggedData = [
            // Regular domains
            ['google.com', true],
            ['news.google.co.uk', true],

            // Long domain with long labels (63 + 1 + 63 + 1 + 63 + 1 + 57 + 1 + 3 = 253 characters)
            ['abcdef0123456789abcdef0123456789abcdef0123456789abcdef012345678.abcdef0123456789abcdef0123456789abcdef0123456789abcdef012345678.abcdef0123456789abcdef0123456789abcdef0123456789abcdef012345678.abcdef0123456789abcdef0123456789abcdef0123456789abcdef012.com', true],

            // Paddings
            [' google.com', self::ALLOW_PADDINGS],
            [' google.com ', self::ALLOW_PADDINGS],
            ['google.com ', self::ALLOW_PADDINGS],
            [" \n\r\t\v\0 google.com \n\r\t\v\0 ", self::ALLOW_PADDINGS],

            // Local domains
            ['a', false],
            ['0', false],
            ['a.b', false],
            ['localhost', false],

            // Punycode
            ['xn--fsqu00a.xn--0zwm56d', false],

            // Internal whitespaces
            ['goo gle.com', false],
            ['google .com', false],
            ['google. com', false],
            ['google.c om', false],

            // Several dots in a raw
            ['google..com', false],
            ['google...com', false],
            ['news.google.co..uk', false],
            ['news.google..co.uk', false],
            ['news..google.co.uk', false],

            // Labels that start or end with a hyphen
            ['google-.com', false],
            ['-google-.com', false],
            ['-google.com', false],
            ['google.-com', false],
            ['google.c-om', false],
            ['google.com-', false],

            // Dots at the beginning or end
            ['.google.com', false],
            ['google.com.', false],

            // Not domains
            ['<script', false],
            ['alert(', false],
            ['.', false],
            ['..', false],
            [' ', false],
            ['-', false],
            ['', false],

            // Too long domain (63 + 1 + 63 + 1 + 63 + 1 + 58 + 1 + 3 = 254 characters)
            ['abcdef0123456789abcdef0123456789abcdef0123456789abcdef012345678.abcdef0123456789abcdef0123456789abcdef0123456789abcdef012345678.abcdef0123456789abcdef0123456789abcdef0123456789abcdef012345678.abcdef0123456789abcdef0123456789abcdef0123456789abcdef0123.com', false],

            // Too long label (64 + 1 + 3)
            ['abcdef0123456789abcdef0123456789abcdef0123456789abcdef0123456789.com', false],

            // Too long label (3 + 1 + 64 + 1 + 3)
            ['www.abcdef0123456789abcdef0123456789abcdef0123456789abcdef0123456789.com', false],
        ];

        $resultData = [];
        foreach ($flaggedData as $pair) {
            if (is_bool($pair[1])) {
                $resultData[] = $pair;
            } else {
                $testString = $pair[0];
                $allowingFlags = $pair[1];
                $resultData[] = [$testString, boolval($allowingFlags & $flags)];
            }
        }

        return $resultData;
    }
}