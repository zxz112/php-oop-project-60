<?php

namespace Hexlet\Tests\Validator;

use Hexlet\Validator\Schema\NumberSchema;
use PHPUnit\Framework\TestCase;

class NumberSchemeTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->schema = new NumberSchema();
    }

    public function testNull()
    {
        $this->assertTrue($this->schema->isValid(null));
    }

    public function testNumber()
    {
        $this->assertTrue($this->schema->isValid(8));
    }

    public function testRequired()
    {
        $this->schema->required();
        $this->assertFalse($this->schema->isValid(null));
    }

    public function testInRange()
    {
        $this->schema->range(-5, 5);

        $this->assertTrue($this->schema->isValid(3));
    }

    public function testOutRange()
    {
        $this->schema->required();
        $this->schema->range(-5, 5);

        $this->assertFalse($this->schema->isValid(6));
    }

    public function testPositive()
    {
        $this->schema->positive();
        $this->assertTrue($this->schema->isValid(6));
        $this->assertFalse($this->schema->isValid(-6));
    }
}
