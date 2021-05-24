<?php
/**
 * Created by PhpStorm.
 * User: maxkamov48
 * Date: 5/20/21
 * Time: 2:28 PM
 */

namespace app\models\forms;


use app\core\Model;
use app\core\validators\EmailValidator;
use app\core\validators\RequiredValidator;

class TaskCreateForm extends Model
{
    public $username = "";
    public $email = "";
    public $text = "";
    public $status = "";
    public $updated_by = "";


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
}