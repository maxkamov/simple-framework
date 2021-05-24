<?php
/**
 * Created by PhpStorm.
 * User: maxkamov48
 * Date: 5/19/21
 * Time: 3:08 AM
 */

namespace app\controllers;


use app\core\Application;
use app\core\BaseController;
use app\core\Request;
use app\models\entities\User;
use app\models\forms\LoginForm;

class AuthController extends BaseController
{
    public function login(Request $request)
    {

        $loginForm = new LoginForm();

        if($request->isPost()){
            $loginForm->loadData($request->getBody());
            $user = User::validateUser($loginForm->username,$loginForm->password);
            if($loginForm->validate() && $user && Application::$app->login($user)){
                Application::$app->session->setFlash('success', 'Вы успешно вошли в систему');
                Application::$app->response->redirect('/home');
            }
        }

        return $this->render('login',[
            'model' => $loginForm
        ]);
    }


    public function logout(Request $request)
    {
        if($request->isGet()){
            Application::$app->logout();
            Application::$app->response->redirect('/home');
        }
    }


}