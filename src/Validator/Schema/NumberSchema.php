<?php

namespace Hexlet\Validator\Schema;

use Hexlet\Validator\Schema\Traits\CustomValidator;
use Hexlet\Validator\Schema\Traits\Required;

class NumberSchema implements SchemaInterface
{
    use Required;
    use CustomValidator;

    private array $range = [];
    private bool $positive = false;

    public function isValid(mixed $value): bool
    {
        try {
            $this->checkRequired($value);
            $this->checkType($value);
            $this->checkCustomValidators($value);
            $this->checkPositive($value);
            $this->checkRange($value);
        } catch (ValidateException $e) {
            return false;
        }

        return true;
    }


    private function checkType(mixed $value): void
    {
        if (!is_null($value) && !is_numeric($value)) {
            throw new ValidateException('type');
        }
    }

    private function checkPositive($value): void
    {
        if ($this->positive && $value < 0) {
            throw new ValidateException('positive');
        }
    }

    private function checkRange($value): void
    {
        if (!empty($this->range)) {
            [$min, $max] = $this->range;

            if ($value < $min || $value > $max) {
                throw new ValidateException('range');
            }
        }
    }
    public function range(int $min, int $max): self
    {
        $this->range = [$min, $max];
        return $this;
    }
    public function positive(): self
    {
        $this->positive = true;
        return $this;
    }
}
