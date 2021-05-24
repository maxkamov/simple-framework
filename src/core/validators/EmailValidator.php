<?php
/**
 * Created by PhpStorm.
 * User: maxkamov48
 * Date: 5/22/21
 * Time: 1:05 AM
 */

namespace app\core\validators;


class EmailValidator implements Validator
{
    private $value;
    private $attribute;

    /**
     * @return bool
     */
    public function validate()
    {
        if(filter_var($this->value, FILTER_VALIDATE_EMAIL)){
            return "";
        }
        return "$this->attribute не валиден";
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @param mixed $attribute
     */
    public function setAttribute($attribute)
    {
        $this->attribute = $attribute;
    }
}