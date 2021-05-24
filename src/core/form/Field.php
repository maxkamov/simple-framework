<?php
/**
 * Created by PhpStorm.
 * User: maxkamov48
 * Date: 5/19/21
 * Time: 3:13 PM
 */

namespace app\core\form;


use app\core\Model;

class Field extends ActiveField
{
    const TYPE_TEXT = 'text';
    const TYPE_PASSWORD = 'password';
    const TYPE_CHECKBOX = 'checkbox';

    public $readonly = "";


    public function __construct(Model $model, $attribute, $params = [])
    {
        $this->type = self::TYPE_TEXT;

        if($params['readonly'] == true){
            $this->readonly = "readonly";
        }

        parent::__construct($model, $attribute);
    }

    public function renderInput()
    {

        $html = sprintf('<input '.$this->readonly.' type="%s" class="form-control%s " name="%s" value="%s">',
            $this->type,
            $this->model->hasError($this->attribute) ? ' is-invalid' : '',
            $this->attribute,
            $this->model->{$this->attribute}
        );

        return $html;
    }



    public function passwordField()
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }


    public function checkboxField()
    {
        $this->type = self::TYPE_CHECKBOX;
        return $this;
    }




}