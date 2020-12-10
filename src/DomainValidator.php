<?php

namespace rugabarbo\DomainValidator;

use Arubacao\TldChecker\Validator;

class DomainValidator
{
    public function isValid(string $value): bool
    {
        return preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $value)
            && preg_match("/^.{1,253}$/", $value)
            && preg_match("/^[^.]{1,63}(\.[^.]{1,63})*$/", $value)
            && Validator::endsWithTld($value);
    }
}