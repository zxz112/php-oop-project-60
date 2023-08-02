<?php
namespace Hexlet\Tests\Validator;

use Hexlet\Validator\Validator;
use PHPUnit\Framework\TestCase;

class CustomValidatorTest extends TestCase
{
    public function test()
    {
        $v = new \Hexlet\Validator\Validator();
        $fn = fn($value, $start) => str_starts_with($value, $start);

        $v->addValidator(Validator::TYPE_STRING, 'startWith', $fn);

        $schema = $v->string();

        $schema->required()->test('startWith', 'H');

        $this->assertFalse($schema->isValid('exlet'));
        $this->assertTrue($schema->isValid('Hexlet'));

        $fn = fn($value, $min) => $value >= $min;
        $v->addValidator(Validator::TYPE_STRING, 'min', $fn);
        $schema = $v->number()->test('min', 5);

        $this->assertFalse($schema->isValid(3)); // false
        $this->assertTrue($schema->isValid(6)); // true


        $this->expectException(\Exception::class);
        $schema->test('test', 1);
    }
}