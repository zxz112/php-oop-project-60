<?php

namespace Hexlet\Validator\Schema\Traits;

use Hexlet\Validator\Schema\ValidateException;

trait Required
{
    protected bool $required = false;

    public function required(): self
    {
        $this->required = true;
        return $this;
    }

    private function checkRequired(mixed $value): void
    {
        if ($this->required && empty($value)) {
            throw new ValidateException('required');
        }
    }
}
