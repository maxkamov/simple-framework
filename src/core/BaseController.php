<?php
/**
 * Created by PhpStorm.
 * User: maxkamov48
 * Date: 5/18/21
 * Time: 10:25 PM
 */

namespace app\core;


class BaseController
{
    public $layout = 'main';

    public function setLayout($layout){
        $this->layout = $layout;
    }

    public function render($view, $params = []){
        return Application::$app->router->renderView($view, $params);
    }

}