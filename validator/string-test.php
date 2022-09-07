<?php
require_once __DIR__ . '/../controller.php';

class StringTest
{

    private $_fieldName;
    public function __construct(private string $value, string $fieldName)
    {
        $this->_fieldName = $fieldName;
    }

    public function email(): StringTest
    {
        if (!preg_match('/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/i', $this->value)) {
            Controller::badRequestException($this->_fieldName . ' should contain a valid email');
        }
        return $this;
    }

    public function alphaNumeric(): StringTest
    {
        if (!preg_match('/^[a-zA-Z0-9]+$/i', $this->value)) {
            Controller::badRequestException($this->_fieldName . ' should contain alpha numeric characters');
        }
        return $this;
    }

    public function base64(): StringTest
    {
        if (!preg_match('/^(?:[A-Za-z\d+/]{4})*(?:[A-Za-z\d+/]{3}=|[A-Za-z\d+/]{2}==)?$/i', $this->value)) {
            Controller::badRequestException($this->_fieldName . ' should contain base64 character');
        }
        return $this;
    }



    public function creditCard(): StringTest
    {
        $regs = [
            'ELECTRON' => "/^(4026|417500|4405|4508|4844|4913|4917)\d+$/",
            'MAESTRO'  => "/^(?:50|5[6-9]|6[0-9])\d+$/",
            'DANKORT ' => "/^(5019|4571)\d+$/",
            'CUP'      => "/^(62|81)\d+$/",
            'VISA'     => "/^4[0-9]\d+$/",
            'DINERS'   => "/^(?:5[45]|36|30[0-5]|3095|3[8-9])\d+$/",
            'MC'       => "/^(?:5[1-5]|222[1-9]|22[3-9][0-9]|2[3-6][0-9][0-9]|27[0-1][0-9]|2720)\d+$/",
            'AMEX'     => "/^(34|37)\d+$/",
            'DISCOVER' => "/^6(?:011|22(12[6-9]|1[3-9][0-9]|[2-8][0-9][0-9]|9[01][0-9]|92[0-5])|5|4|2[4-6][0-9]{3}|28[2-8][0-9]{2})\d+$/",
            'JCB'      => "/^(?:35[2-8][0-9])\d+$/",
            'INTERPAY' => "/^(636)\d+$/",
            'KOREAN'   => "/^9[0-9]\d+$/",
            'MIR'      => "/^(?:220[0-4])\d+$/",
        ];

        $valid = false;


        foreach ($regs as $brand => $reg) {
            if (preg_match($reg, $this->value)) {
                $valid = true;
                break;
            }
        }

        if (!$valid) {
            Controller::badRequestException($this->_fieldName . ' should contain a valid credit card number');
        }
        return $this;
    }

    public function domain(): StringTest
    {
        if (!preg_match('/^(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z0-9][a-z0-9-]{0,61}[a-z0-9]$/i', $this->value)) {
            Controller::badRequestException($this->_fieldName . ' should contain a domain');
        }
        return $this;
    }

    public function guid(): StringTest
    {
        if (!preg_match('/^([0-9A-Fa-f]{8}[-][0-9A-Fa-f]{4}[-][0-9A-Fa-f]{4}[-][0-9A-Fa-f]{4}[-][0-9A-Fa-f]{12})$/i', $this->value)) {
            Controller::badRequestException($this->_fieldName . ' should contain a guid');
        }
        return $this;
    }

    public function hex(): StringTest
    {
        if (!preg_match('/(0x)?[0-9a-f]+/i', $this->value)) {
            Controller::badRequestException($this->_fieldName . ' should contain a hex value');
        }
        return $this;
    }

    public function hostname(): StringTest
    {
        if (!preg_match('/^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])$/i', $this->value)) {
            Controller::badRequestException($this->_fieldName . ' should contain a hostname value');
        }
        return $this;
    }

    public function ip($ipv6 = false): StringTest
    {
        $regex = $ipv6 ? '/(([0-9a-fA-F]{1,4}:){7,7}[0-9a-fA-F]{1,4}|([0-9a-fA-F]{1,4}:){1,7}:|([0-9a-fA-F]{1,4}:){1,6}:[0-9a-fA-F]{1,4}|([0-9a-fA-F]{1,4}:){1,5}(:[0-9a-fA-F]{1,4}){1,2}|([0-9a-fA-F]{1,4}:){1,4}(:[0-9a-fA-F]{1,4}){1,3}|([0-9a-fA-F]{1,4}:){1,3}(:[0-9a-fA-F]{1,4}){1,4}|([0-9a-fA-F]{1,4}:){1,2}(:[0-9a-fA-F]{1,4}){1,5}|[0-9a-fA-F]{1,4}:((:[0-9a-fA-F]{1,4}){1,6})|:((:[0-9a-fA-F]{1,4}){1,7}|:)|fe80:(:[0-9a-fA-F]{0,4}){0,4}%[0-9a-zA-Z]{1,}|::(ffff(:0{1,4}){0,1}:){0,1}((25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9])\.){3,3}(25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9])|([0-9a-fA-F]{1,4}:){1,4}:((25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9])\.){3,3}(25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9]))/i' : '/(\b25[0-5]|\b2[0-4][0-9]|\b[01]?[0-9][0-9]?)(\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)){3}/i';
        if (!preg_match($regex, $this->value)) {
            Controller::badRequestException($this->_fieldName . ' should contain a ' . ($ipv6 ? ' ipv6' : 'ipv4') . ' address');
        }
        return $this;
    }

    public function length(int $len): StringTest
    {
        if (strlen(trim($this->value)) === $len) {
            Controller::badRequestException($this->_fieldName . ' should contain only ' . $len . ' characters');
        }
        return $this;
    }

    public function lowercase(): StringTest
    {
        $regex = '/[a-z]+/';
        if (!preg_match($regex, $this->value)) {
            Controller::badRequestException($this->_fieldName . ' should contain only lowercase characters');
        }
        return $this;
    }

    public function min(int $len): StringTest
    {
        if (strlen(trim($this->value)) < $len) {
            Controller::badRequestException($this->_fieldName . ' should contain minimum of ' . $len . ' characters');
        }
        return $this;
    }

    public function max(int $len): StringTest
    {
        if (strlen(trim($this->value)) > $len) {
            Controller::badRequestException($this->_fieldName . ' should contain maximum of ' . $len . ' characters');
        }
        return $this;
    }


    public function pattern(string $regex): StringTest
    {
        if (!preg_match($regex, $this->value)) {
            Controller::badRequestException($this->_fieldName . ' should match pattern');
        }
        return $this;
    }



    public function uppercase(): StringTest
    {
        $regex = '/[a-z]+/';
        if (!preg_match($regex, $this->value)) {
            Controller::badRequestException($this->_fieldName . ' should contain only lowercase characters');
        }
        return $this;
    }

    public function uri(): StringTest
    {
        $regex = '/\w+:(\/?\/?)[^\s]+/';
        if (!preg_match($regex, $this->value)) {
            Controller::badRequestException($this->_fieldName . ' should contain only lowercase characters');
        }
        return $this;
    }
}
