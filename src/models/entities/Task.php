<?php
/**
 * Created by PhpStorm.
 * User: maxkamov48
 * Date: 5/20/21
 * Time: 2:21 PM
 */

namespace app\models\entities;


use app\core\ActiveRecord;
use app\core\validators\EmailValidator;
use app\core\validators\RequiredValidator;

class Task extends ActiveRecord
{
    const OPEN = 10;
    const FINISHED = 20;

    public $username;
    public $email;
    public $text;
    public $status;
    public $updated_by;


    public function tableName()
    {
        return "task";
    }

    public function rules()
    {
        return [
            'email' => [
                [RequiredValidator::class,'validate'],
                [EmailValidator::class,'validate'],
            ],
            'username' => [[RequiredValidator::class,'validate']],
            'text' => [[RequiredValidator::class,'validate']],
        ];
    }

    public function labels()
    {
        return [
            'username' => 'Имя',
            'email' => 'Email',
            'text' => 'Текст',
            'status' => 'status',
            'updated_by' => 'updated_by',
        ];
    }

    public function attributes()
    {
        return ['username','text','email','status','updated_by'];
    }

    public function primaryKey()
    {
        return 'id';
    }


    public static function getTaskStatus($status,$updated_by){

        $message = "";

        if($status == self::FINISHED){
            $message .= "<h4><span class=\"label label-success\">выполнено: </span></h4> ";
        }

        if($status == self::OPEN){
            $message .= "<h4><span class=\"label label-danger\">Не выполнено</span></h4>";
        }

        if($updated_by == "Admin"){
            $message .= "<h5>отредактировано администратором</h5> ";
        }

        return $message;
    }


}