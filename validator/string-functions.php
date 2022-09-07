<?php
require_once __DIR__ . '/../controller.php';
require_once __DIR__ . '/string-test.php';

class StringFunctions
{
    private $_fieldName;
    public function __construct(public string $value, string $fieldName)
    {
        $this->_fieldName = $fieldName;
    }

    public function case(bool $upper): StringFunctions
    {
        if ($upper) {
            $this->value = strtoupper($this->value);
        } else {
            $this->value = strtolower($this->value);
        }
        return $this;
    }

    public function test(): StringTest
    {
        return new StringTest($this->value, $this->_fieldName);
    }

    public function trim(): StringFunctions
    {
        $this->value = trim($this->value);
        return $this;
    }
}