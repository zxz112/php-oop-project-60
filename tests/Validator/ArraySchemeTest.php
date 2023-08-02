<?php
namespace Hexlet\Tests\Validator;

use Hexlet\Validator\Schema\ArraySchema;
use Hexlet\Validator\Schema\NumberSchema;
use Hexlet\Validator\Schema\StringSchema;
use PHPUnit\Framework\TestCase;

class ArraySchemeTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->schema = new ArraySchema();
    }

    public function testNull()
    {
        $this->assertTrue($this->schema->isValid(null));
    }

    public function testEmptyArray()
    {
        $this->assertTrue($this->schema->isValid([]));
    }

    public function testRequired()
    {
        $this->schema->required();
        $this->assertFalse($this->schema->isValid(null));
    }

    public function testArray()
    {
        $this->assertTrue($this->schema->isValid(['test']));
    }

    public function testSizeOf()
    {
        $this->schema->sizeOf(2);

        $this->assertFalse($this->schema->isValid(['test']));
        $this->assertTrue($this->schema->isValid(['test', 'test']));
    }

    public function testShape()
    {
        $stringSchema = new StringSchema();
        $numberSchema = new NumberSchema();

        $this->schema->shape([
            'name' => $stringSchema->required(),
            'age' => $numberSchema->positive()
        ]);

        $this->assertTrue($this->schema->isValid(
            ['name' => 'kolya', 'age' => 100]
        ));

        $this->assertTrue($this->schema->isValid(
            ['name' => 'kolya', 'age' => 100]
        ));

        $this->assertFalse($this->schema->isValid(
            ['name' => '', 'age' => null]
        ));

        $this->assertFalse($this->schema->isValid(
            ['name' => 'as', 'age' => -5]
        ));
    }
}