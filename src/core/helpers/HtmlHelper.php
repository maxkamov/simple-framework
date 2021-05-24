<?php
/**
 * Created by PhpStorm.
 * User: maxkamov48
 * Date: 5/24/21
 * Time: 6:08 AM
 */

namespace app\core\helpers;


class HtmlHelper
{
    public static function encode($string)
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}