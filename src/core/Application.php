<?php
/**
 * Created by PhpStorm.
 * User: maxkamov48
 * Date: 5/18/21
 * Time: 4:38 PM
 */

namespace app\core;


use app\models\entities\User;

class Application
{

    public static $ROOT_DIR;
    public $router;
    public $request;
    public $response;
    public $controller;
    public $db;
    public $user;
    public $session;
    public static $app;

    public function __construct($rootPath, $config = [])
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->db = new Database($config['db']);
        $this->session = new Session();
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->initIdentity();
    }

    private function initIdentity(){
        $user = $this->session->get('user');
        if(!empty($user)){
            $this->user = User::getUserById($user);
        }
    }

    public static function isGuest()
    {
        return !self::$app->user;
    }

    public function login(User $user)
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $value = $user->{$primaryKey};
        Application::$app->session->set('user', $value);

        return true;
    }

    public function logout()
    {
        $this->user = null;
        self::$app->session->remove('user');
    }

    public function run()
    {
        $this->router->resolve();
    }

}