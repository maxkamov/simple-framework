<?php
/**
 * Created by PhpStorm.
 * User: maxkamov48
 * Date: 5/19/21
 * Time: 4:37 AM
 */

namespace app\core;


use app\core\validators\Validator;

class Model
{

    public $errors = [];

    public function loadData($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    public function attributes()
    {
        return [];
    }

    public function labels()
    {
        return [];
    }

    public function getLabel($attribute)
    {
        return $this->labels()[$attribute] ?? $attribute;
    }

    public function rules()
    {
        return [];
    }

    private function getValidator($className,$attribute,$value)
    {
        $object = new $className();
        if($object instanceof Validator){
            $object->setValue($value);
            $object->setAttribute($this->getLabel($attribute));
            return $object;
        }
        throw new \DomainException('Class class must implement Validator interface');
    }


    public function validate(){

        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};

            foreach ($rules as $rule) {
                $ruleClassName = $rule[0];
                $ruleMethod = $rule[1];

                $has_message = "";

                if(is_string($ruleClassName)){
                    $object = $this->getValidator($ruleClassName,$attribute,$value);
                    $has_message = $object->validate();
                }elseif (is_object($ruleClassName)){
                    $has_message = $ruleClassName->$ruleMethod();
                }


                if(!empty($has_message)){
                    $this->addError($attribute,$has_message);
                }
            }


        }
        return empty($this->errors);
    }


    public function addError( $attribute, $message)
    {
        $this->errors[$attribute][] = $message;
    }

    public function hasError($attribute)
    {
        return $this->errors[$attribute] ?? false;
    }

    public function getFirstError($attribute)
    {
        $errors = $this->errors[$attribute] ?? [];
        return $errors[0] ?? '';
    }

}