<?php
namespace Hexlet\Tests\Validator;

use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    public function testDifferentSchemes()
    {
        $v = new \Hexlet\Validator\Validator();
        $schema1 = $v->string();
        $schema2 = $v->string();

        $this->assertNotSame($schema1, $schema2);
    }
}