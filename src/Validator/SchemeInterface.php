<?php
namespace Hexlet\Validator;

interface SchemeInterface
{
    public function isValid();
    public function required();
}