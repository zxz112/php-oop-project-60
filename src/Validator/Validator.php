<?php
namespace Hexlet\Validator;

class Validator
{
    public function string()
    {
        return new StringScheme();
    }
}