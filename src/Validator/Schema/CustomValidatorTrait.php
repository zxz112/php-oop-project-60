<?php
namespace Hexlet\Validator\Schema;

trait CustomValidatorTrait
{
    private array $validators = [];
    private array $enabledValidators = [];
    public function setValidators(array $validators) :void
    {
        $this->validators = $validators;
    }

    public function test(string $name, $value) :self
    {
        if (!array_key_exists($name, $this->validators)) {
            throw new \Exception('eerr');
        }

        $this->enabledValidators[$name] = [
            'validator' =>$this->validators[$name],
            'param' => $value
        ];

        return $this;
    }

    private function checkCustomValidators(mixed $value) :void
    {
        if (empty($this->enabledValidators)) {
            return;
        }

        foreach ($this->enabledValidators as $name => $validator) {
            if (!$validator['validator']($value, $validator['param'])) {
                throw new ValidateException($name . " custom validator fail");
            }
        }
    }
}
