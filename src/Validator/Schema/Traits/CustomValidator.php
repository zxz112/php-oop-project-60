<?php

namespace Hexlet\Validator\Schema\Traits;

use Hexlet\Validator\Schema\ValidateException;

trait CustomValidator
{
    private array $validators = [];
    private array $enabledValidators = [];
    public function setValidators(array $validators): void
    {
        $this->validators = $validators;
    }

    public function test(string $name, mixed $value): self
    {
        if (!array_key_exists($name, $this->validators)) {
            throw new ValidateException('custom validator error');
        }

        $this->enabledValidators[$name] = [
            'validator' => $this->validators[$name],
            'param' => $value
        ];

        return $this;
    }

    private function checkCustomValidators(mixed $value): void
    {
        if (count($this->enabledValidators) === 0) {
            return;
        }

        foreach ($this->enabledValidators as $name => $validator) {
            if (!$validator['validator']($value, $validator['param'])) {
                throw new ValidateException($name . " custom validator fail");
            }
        }
    }
}
