<?php

namespace rugabarbo\DomainValidator;

use Arubacao\TldChecker\Validator;
use function Symfony\Component\String\u;

class DomainValidator
{
    private bool $paddingsAllowed = false;

    public function allowPaddings(): self
    {
        $this->paddingsAllowed = true;

        return $this;
    }

    public function allowIDN(): self
    {
        //TODO: Implement

        return $this;
    }

    public function allowPunycode(): self
    {
        //TODO: Implement

        return $this;
    }

    public function allowLocal(): self
    {
        //TODO: Implement

        return $this;
    }

    public function allowTestTLD(): self
    {
        //TODO: Implement

        return $this;
    }

    public function allowOnlySpecifiedTLDs(array $TLDs): self
    {
        //TODO: Implement

        return $this;
    }

    public function allowDomainUnderscores(): self
    {
        //TODO: Implement

        return $this;
    }

    public function allowSubdomainUnderscores(): self
    {
        //TODO: Implement

        return $this;
    }

    public function disallowSubdomains(): self
    {
        //TODO: Implement

        return $this;
    }

    public function allowOnlyExistingDNSRecords(string $type = 'A'): self
    {
        //TODO: Implement

        return $this;
    }

    public function isValid(string $value): bool
    {
        $value = u($value);

        if ($this->paddingsAllowed) {
            $value = $value->trim();
        }

        $value = $value->toString();

        return preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $value)
            && preg_match("/^.{1,253}$/", $value)
            && preg_match("/^[^.]{1,63}(\.[^.]{1,63})*$/", $value)
            && Validator::endsWithTld($value);
    }
}