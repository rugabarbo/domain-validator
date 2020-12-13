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

        if ($value->length() > 253) {
            return false;
        }

        $labels = $value->split('.');

        if (count($labels) === 1) {
            return false;
        }

        foreach ($labels as $label) {
            if (!$label->match('/^[a-zA-Z\d-]{1,63}$/')) {
                return false;
            }

            if ($label->startsWith('-') || $label->endsWith('-')) {
                return false;
            }
        }

        $value = $value->toString();

        return Validator::endsWithTld($value);
    }
}