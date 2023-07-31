<?php
namespace Hexlet\Validator;

class StringScheme
{
    private bool $required;
    private int $minLength = 0;
    private string $contains = "";
    public function __construct()
    {
        $this->required = false;
    }

    public function isValid($string): bool
    {
        if ($this->required && empty($string)) {
            return false;
        }

        if ($this->minLength && strlen($string) < $this->minLength) {
            return false;
        }

        if ($this->contains && !str_contains($string, $this->contains)) {
            return false;
        }

        return true;
    }

    public function required() :self
    {
        $this->required = true;
        return $this;
    }

    public function minLength(int $length) :self
    {
        $this->minLength = $length;
        return $this;
    }


    public function contains($string) :self
    {
        $this->contains = $string;
        return $this;
    }
}
