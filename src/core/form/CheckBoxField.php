<?php
/**
 * Created by PhpStorm.
 * User: maxkamov48
 * Date: 5/24/21
 * Time: 8:17 AM
 */

namespace app\core\form;


use app\models\entities\Task;

class CheckBoxField extends ActiveField
{
    public function renderInput()
    {
        $checked = "";

        if($this->model->{$this->attribute} == Task::FINISHED){
            $checked = "checked";
        }

        return sprintf('<input class="form-check-input" type="checkbox" name="%s" id="defaultCheck1" %s>',
            $this->attribute,
            $checked
        );
    }
}