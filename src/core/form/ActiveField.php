<?php
/**
 * Created by PhpStorm.
 * User: maxkamov48
 * Date: 5/21/21
 * Time: 9:15 PM
 */

namespace app\core\form;


abstract class ActiveField extends BaseField
{

    public $template = '<div class="form-group {{errorClass}}">
                <label>{{label}}</label>
                {{input}}
                <div class="invalid-feedback text-danger">
                    {{errorMessage}}
                </div>
            </div>';


    public function setTemplate($template){
        $this->template = $template;
        return $this;
    }


    public function __toString()
    {
        $error = "";
        if($this->model->hasError($this->attribute)){
            $error .= " has-error";
        }
        $this->template = str_replace('{{errorClass}}',$error,$this->template);
        $this->template = str_replace('{{label}}',$this->model->getLabel($this->attribute),$this->template);
        $this->template = str_replace('{{input}}',$this->renderInput(),$this->template);
        $this->template = str_replace('{{errorMessage}}',$this->model->getFirstError($this->attribute),$this->template);
        return $this->template;
    }


}