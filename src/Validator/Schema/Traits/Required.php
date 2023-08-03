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

    abstract private function checkRequired(mixed $value);
}
