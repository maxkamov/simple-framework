<?php
/**
 * Created by PhpStorm.
 * User: maxkamov48
 * Date: 5/19/21
 * Time: 4:40 AM
 */

namespace app\models\forms;


use app\core\Model;
use app\core\validators\EmailValidator;
use app\core\validators\RequiredValidator;
use app\models\entities\User;

class LoginForm extends Model
{

    public $username = '';
    public $password = '';


    public function rules()
    {
        return [
            'username' => [
                [RequiredValidator::class,'validate'],
                [$this,'isValid']
            ],
            'password' => [[RequiredValidator::class,'validate']],
        ];
    }

    public function labels()
    {
        return [
            'username' => 'Имя пользователя',
            'password' => 'Пароль'
        ];
    }

    public function isValid(){
//        Application::$app->session->setFlash('error', 'Неверные учетные данные для доступа');
        if(empty($this->password)){
            return "";
        }
        $user = User::validateUser($this->username,$this->password);
        if($user){
            return "";
        }
        return "Неверные учетные данные для доступа";
    }




//    public function login()
//    {
//        $user = User::findOne(['email' => $this->email]);
//        if (!$user) {
//            $this->addError('email', 'User does not exist with this email address');
//            return false;
//        }
//        if (!password_verify($this->password, $user->password)) {
//            $this->addError('password', 'Password is incorrect');
//            return false;
//        }
//
//        return Application::$app->login($user);
//    }

}