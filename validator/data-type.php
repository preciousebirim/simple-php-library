<?php
class DataType
{

    private $_data;
    private $_fieldName;

    public function __construct(string $data, string $fieldName)
    {
        $this->_data = $data;
        $this->_fieldName = $fieldName;
    }
    public function string(): StringFunctions
    {
        if (!is_string($this->_data)) {
            Controller::badRequestException($this->_fieldName . ' should be a string');
        }

        return new StringFunctions($this->_data, $this->_fieldName);
    }

    public function int(): StringFunctions
    {
        if (!is_numeric($this->_data)) {
            Controller::badRequestException($this->_fieldName . ' should be a string');
        }

        $this->_data = (int) $this->_data;

        return new StringFunctions($this->_data, $this->_fieldName);
    }
}