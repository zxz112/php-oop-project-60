<?php
namespace Hexlet\Validator\Schema;

interface SchemaInterface
{
    public function isValid(mixed $value) :bool;
    public function setValidators(array $validators) :void;
}