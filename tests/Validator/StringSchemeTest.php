<?php
namespace Hexlet\Tests\Validator;

use Hexlet\Validator\Schema\StringSchema;
use PHPUnit\Framework\TestCase;

class StringSchemeTest extends TestCase
{
    public function test()
    {
        $scheme = new StringSchema();

//        $this->assertTrue($scheme->isValid(''));
        $this->assertTrue($scheme->isValid(null));
//        $this->assertTrue($scheme->isValid('what does the fox say'));

        $scheme->required();

        $this->assertFalse($scheme->isValid(''));
        $this->assertFalse($scheme->isValid(null));
        $this->assertTrue($scheme->isValid('hexlet'));
    }

    public function testMinLength()
    {
        $scheme = new StringSchema();
        $scheme->minLength(10);

        $this->assertFalse($scheme->isValid('hexlet'));
        $this->assertTrue($scheme->isValid('morethantensymbols'));
        $this->assertTrue($scheme->isValid('0000000000'));

        $result = $scheme->minLength(10)->minLength(1)->isValid("Hexlet");

        $this->assertTrue($result);
    }

    public function testContains()
    {
        $scheme = new StringSchema();
        $scheme->contains('one');

        $this->assertTrue($scheme->isValid('one two '));

        $scheme->contains('three');

        $this->assertFalse($scheme->isValid('one two '));
    }
}