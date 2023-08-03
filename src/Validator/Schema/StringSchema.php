<?php

namespace Hexlet\Validator\Schema;

use Hexlet\Validator\Schema\Traits\CustomValidator;
use Hexlet\Validator\Schema\Traits\Required;

class StringSchema implements SchemaInterface
{
    use Required;
    use CustomValidator;

    private int $minLength = 0;
    private string $contains = "";

    public function isValid(mixed $value): bool
    {
        try {
            $this->checkRequired($value);
            $this->checkType($value);
            $this->checkCustomValidators($value);
            $this->checkMinLength((string)$value);
            $this->checkContains((string)$value);
        } catch (ValidateException $e) {
            return false;
        }

        return true;
    }

    private function checkType(mixed $value): void
    {
        if (!is_null($value) && !is_string($value)) {
            throw new ValidateException("not a string");
        }
    }
    private function checkMinLength(mixed $value): void
    {
        if ($this->minLength && is_string($value) && strlen($value) < $this->minLength) {
            throw new ValidateException("not a string");
        }
    }

    private function checkContains(mixed $value): void
    {
        if ($this->contains && !str_contains($value, $this->contains)) {
            throw new ValidateException("not a string");
        }
    }

    public function minLength(int $length): self
    {
        $this->minLength = $length;
        return $this;
    }


    public function contains(mixed $string): self
    {
        $this->contains = $string;
        return $this;
    }
}
