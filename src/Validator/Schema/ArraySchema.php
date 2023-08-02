<?php
namespace Hexlet\Validator\Schema;

class ArraySchema implements SchemaInterface
{
    use RequiredTrait, CustomValidatorTrait;

    private ?int $sizeOf = null;

    private ?array $shape = null;

    public function isValid(mixed $value): bool
    {
        try {
            $this->checkRequired($value);
            $this->checkType($value);
            $this->checkCustomValidators($value);
            $this->checkSizeOf($value);
            $this->checkShape($value);
        } catch (ValidateException $e) {
            return false;
        }

        return true;
    }

    private function checkType(mixed $value) :void
    {
        if (!is_null($value) && !is_array($value)) {
            throw new ValidateException('type');
        }
    }
    private function checkSizeOf($value) :void
    {
        if ($this->sizeOf > 0 && $this->sizeOf > count($value)) {
            throw new ValidateException('sizeof');
        }
    }

    private function checkShape($value) :void
    {
        if ($this->shape) {
            foreach ($this->shape as $key => $rule) {
                if (!array_key_exists($key, $value) || !$rule->isValid($value[$key])) {
                    throw new ValidateException('shape');
                }
            }
        }
    }

    public function sizeOf(int $size) :self
    {
        $this->sizeOf = $size;
        return $this;
    }

    public function shape(array $rules) :self
    {
        $this->shape = $rules;
        return $this;
    }
}
