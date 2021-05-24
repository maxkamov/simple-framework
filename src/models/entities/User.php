<?php
/**
 * Created by PhpStorm.
 * User: maxkamov48
 * Date: 5/19/21
 * Time: 9:54 PM
 */

namespace app\models\entities;


use app\core\ActiveRecord;

class User extends ActiveRecord
{
    public $username;
    public $password;
    public $email;
    public $status;

    public function tableName()
    {
        return "user";
    }

    public function rules()
    {
        return [];
    }

    public function attributes()
    {
        return ['username','password','email','status'];
    }

    public function primaryKey()
    {
        return 'id';
    }

    public static function getUserById($id){
        $userArray = (new User())->select(['id','username','email','password','status'])
            ->where("id", $id, "=")
            ->getAsArray();

        if(!empty($userArray)){
            $user = new User();
            $user->id = $userArray['id'];
            $user->username = $userArray['username'];
            $user->password = $userArray['password'];
            $user->email = $userArray['email'];
            $user->status = $userArray['status'];
            return $user;
        }

        return null;
    }

    public static function validateUser($username, $password){
        $userArray = (new User())->select(['id','username','password'])
            ->where("username", $username, "=")
            ->getAsArray();

        if(!empty($userArray) && $userArray['password'] == $password){
            $user = new User();
            $user->id = $userArray['id'];
            $user->username = $userArray['username'];
            $user->password = $userArray['password'];
            return $user;
        }

        return false;

    }
}