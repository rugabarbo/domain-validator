<?php

namespace rugabarbo\DomainValidator;

use Arubacao\TldChecker\Validator;
use InvalidArgumentException;
use Symfony\Component\String\UnicodeString;
use function Symfony\Component\String\u;

class DomainValidator
{
    private bool $paddingsAllowed = false;
    private bool $IDNAllowed = false;

    public function allowPaddings(): self
    {
        $this->paddingsAllowed = true;

        return $this;
    }

    public function allowIDN(): self
    {
        $this->IDNAllowed = true;

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
        try {
            $value = u($value);
        } catch (InvalidArgumentException $e) {
            return false;
        }

        if ($this->paddingsAllowed) {
            $value = $value->trim();
        }

        $asciiValue = idn_to_ascii($value, IDNA_NONTRANSITIONAL_TO_ASCII, INTL_IDNA_VARIANT_UTS46, $info);

        if ($asciiValue === false) {
            return false;
        }

        if ($value->toString() !== $asciiValue) {
            if (!$this->IDNAllowed) {
                return false;
            }

            if ($info !== null && $info['errors'] !== 0) {
                return false;
            }

            $value = u($asciiValue);
        }

        if ($value->length() > 253) {
            return false;
        }

        $labels = $value->split('.');

        if (count($labels) === 1) {
            return false;
        }

        /** @var UnicodeString $label */
        foreach ($labels as $label) {
            if (!$label->match('/^[a-zA-Z\d-]{1,63}$/')) {
                return false;
            }

            if ($label->startsWith('-') || $label->endsWith('-')) {
                return false;
            }
        }

        $lastLabel = $label;

        return Validator::isTld($lastLabel);
    }
}