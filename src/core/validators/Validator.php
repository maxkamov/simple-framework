<?php
/**
 * Created by PhpStorm.
 * User: maxkamov48
 * Date: 5/22/21
 * Time: 1:07 AM
 */

namespace app\core\validators;


interface Validator
{
    public function validate();

    public function setValue($value);

    public function setAttribute($attribute);

}