<?php

namespace rugabarbo\DomainValidator\Test;

use PHPUnit\Framework\TestCase;
use rugabarbo\DomainValidator\DomainValidator;

final class DomainValidatorTest extends TestCase
{
    public function defaultProvider(): array
    {
        return DataProviderBuilder::getData();
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

    public function allowPaddingsProvider(): array
    {
        return DataProviderBuilder::getData(DataProviderBuilder::ALLOW_PADDINGS);
    }

    /**
     * @dataProvider allowPaddingsProvider
     * @param string $value
     * @param bool $isValid
     */
    public function testAllowAutoTrim(string $value, bool $isValid): void
    {
        $validator = (new DomainValidator())->allowPaddings();
        $this->assertEquals($isValid, $validator->isValid($value));
    }
}
