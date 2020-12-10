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

            // Wrong domains
            ['goo gle.com', false],
            ['google..com', false],
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