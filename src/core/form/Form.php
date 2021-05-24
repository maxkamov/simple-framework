<?php
/**
 * Created by PhpStorm.
 * User: maxkamov48
 * Date: 5/19/21
 * Time: 3:12 PM
 */

namespace app\core\form;


use app\core\Model;

class Form
{
    public static function begin($action, $method, $options = [])
    {
        $attributes = [];
        foreach ($options as $key => $value) {
            $attributes[] = "$key=\"$value\"";
        }

        echo sprintf('<form action="%s" method="%s" %s>', $action, $method, implode(" ", $attributes));
        return new Form();
    }

    public static function end()
    {
        echo '</form>';
    }

    public function field(Model $model, $attribute, $params = [])
    {
        return new Field($model, $attribute, $params);
    }

    public function hiddenField(Model $model, $attribute)
    {
        return new HiddenField($model, $attribute);
    }

    public function checkboxField(Model $model, $attribute, $template = false)
    {

         $field = new CheckBoxField($model, $attribute);

         if($template){
             $field->setTemplate($template);
         }

         return $field;
    }

}