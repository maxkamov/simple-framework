<?php
/**
 * Created by PhpStorm.
 * User: maxkamov48
 * Date: 5/18/21
 * Time: 4:53 PM
 */

namespace app\core;


class Router
{

    public $routes = [];
    protected $request;
    protected $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }


    public function get( $path, $callback )
    {
        $this->routes['get'][$path] = $callback;
    }


    public function post( $path, $callback )
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;

        if($callback === false){
            $this->response->setStatusCode(404);
            echo $this->renderView('error');
            exit;
        }

        if(is_string($callback)){
           echo $this->renderView($callback);
           exit;
        }

        if(is_array($callback)){
            Application::$app->controller = new $callback[0]();
            $callback[0] = Application::$app->controller;
        }

        echo call_user_func($callback, $this->request);
    }


    public function renderView($view, $params = []){
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view, $params);
        return str_replace("{{content}}", $viewContent, $layoutContent);
    }

    private function layoutContent(){

        $layout = Application::$app->controller->layout;
        ob_start();
        include_once Application::$ROOT_DIR."/views/layouts/$layout.php";
        $html = ob_get_contents();
        ob_get_clean();

        return $html;
    }


    public function renderOnlyView($view, $params){

        foreach ($params as $key => $value){
            $$key = $value;
        }

        ob_start();
        include_once Application::$ROOT_DIR."/views/$view.php";
        $html = ob_get_contents();
        ob_get_clean();
        return $html;
    }

}