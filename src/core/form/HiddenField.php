<?php
/**
 * Created by PhpStorm.
 * User: maxkamov48
 * Date: 5/21/21
 * Time: 6:49 PM
 */

namespace app\core\form;


class HiddenField extends BaseField
{

    public function __toString()
    {
        return $this->renderInput();
    }

    public function renderInput()
    {
        return sprintf('<input type="hidden" id="customId" name="%s" value="%s">',
            $this->attribute,
            $this->model->{$this->attribute}
        );
    }
}