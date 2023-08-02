<?php
namespace Hexlet\Validator;

use Hexlet\Validator\Schema\ArraySchema;
use Hexlet\Validator\Schema\NumberSchema;
use Hexlet\Validator\Schema\SchemaInterface;
use Hexlet\Validator\Schema\StringSchema;

class Validator
{
    const TYPE_STRING = 'string';
    const TYPE_NUMBER = 'number';
    const TYPE_ARRAY = 'array';
    private array $validators = [];
    public function string() :StringSchema
    {
        $schema = new StringSchema();
        $this->setValidators($schema, self::TYPE_STRING);

        return $schema;
    }

    public function array() :ArraySchema
    {
        $schema = new ArraySchema();
        $this->setValidators($schema, self::TYPE_STRING);

        return $schema;
    }

    public function number() :NumberSchema
    {
        $schema = new NumberSchema();
        $this->setValidators($schema, self::TYPE_STRING);

        return $schema;
    }

    private function setValidators(SchemaInterface $schema, string $type) :void
    {
        if (is_array($this->validators[$type])) {
            $schema->setValidators($this->validators[$type]);
        }
    }

    public function addValidator(string $type, string $name, callable $fn) :void
    {
        if (!self::isValidatorAvailable($type)) {
            throw new ErrorTypeValidatorException('not supported');
        }

        $this->validators[$type][$name] = $fn;
    }

    private static function isValidatorAvailable(string $type) :bool
    {
        return in_array($type, [
            self::TYPE_ARRAY,
            self::TYPE_STRING,
            self::TYPE_NUMBER
        ]);
    }
}
