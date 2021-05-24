<?php
/**
 * Created by PhpStorm.
 * User: maxkamov48
 * Date: 5/19/21
 * Time: 3:13 PM
 */

namespace app\core\form;


use app\core\Model;

abstract class BaseField
{

    public $model;
    public $attribute;
    public $type;


    public function __construct(Model $model, $attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;
    }


    abstract public function renderInput();
}