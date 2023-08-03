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
            $this->checkType($value);
            $this->checkRequired($value);
            $this->checkCustomValidators($value);
            $this->checkMinLength((string)$value);
            $this->checkContains((string)$value);
        } catch (ValidateException $e) {
            return false;
        }

        return true;
    }

    private function checkRequired(mixed $value): void
    {
        if ($this->required && (!is_string($value) || strlen($value) === 0)) {
            throw new ValidateException('required');
        }
    }

    private function checkType(mixed $value): void
    {
        if (!is_null($value) && !is_string($value)) {
            throw new ValidateException('wrong type');
        }
    }

    private function checkMinLength(mixed $value): void
    {
        if ($this->minLength > 0 && is_string($value) && strlen($value) < $this->minLength) {
            throw new ValidateException("not a string");
        }
    }

    private function checkContains(mixed $value): void
    {
        if (strlen($this->contains) > 0 && !str_contains($value, $this->contains)) {
            throw new ValidateException("not a string");
        }
    }

    public function minLength(int $length): self
    {
        $this->minLength = $length;
        return $this;
    }


    public function contains(string $string): self
    {
        $this->contains = $string;
        return $this;
    }
}
