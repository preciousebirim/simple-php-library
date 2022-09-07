<?php
require_once __DIR__ . '/../controller.php';
require_once __DIR__ . '/data-type.php';


class Validator
{
  private ?int $requestMethod = null;
    public function __construct(int $requestMethod)
    {
        $this->requestMethod = $requestMethod;
    }

    public function add(string $fieldName, bool $required = true): DataType
    {
        if ($this->requestMethod === 0 && $required && isset($_GET[$fieldName]) === false) {
            Controller::badRequestException($fieldName . ' is missing GET in request');
        }

        if ($this->requestMethod === 1 && $required && isset($_POST[$fieldName]) === false) {
            Controller::badRequestException($fieldName . ' is missing POST in request');
        }
        if ($this->requestMethod > 1) {
            Controller::badRequestException(' Unknown request Provided is missing in request');
        }

        $data = $this->requestMethod === 0 ? $_GET[$fieldName] : $_POST[$fieldName];
        return new DataType($data, $fieldName);
    }
}
