<?php
/**
 * Created by PhpStorm.
 * User: maxkamov48
 * Date: 5/18/21
 * Time: 12:59 PM
 */


require_once __DIR__.'/../vendor/autoload.php';

use app\controllers\AuthController;
use app\controllers\TaskController;
use app\core\Application;
use app\controllers\SiteController;


$config = [
    'db' => [
        'dsn' => 'mysql:host=mysql;dbname=homestead',
        'user' => 'homestead',
        'password' => 'secret',
    ]
];

$app = new Application(dirname(__DIR__), $config);

$app->router->get('/', [SiteController::class,'home']);
$app->router->get('/home', [SiteController::class,'home']);


$app->router->get('/logout', [AuthController::class,'logout']);

$app->router->get('/login', [AuthController::class,'login']);
$app->router->post('/login', [AuthController::class,'login']);


$app->router->get('/task-create', [TaskController::class,'create']);
$app->router->post('/task-create', [TaskController::class,'create']);

$app->router->get('/task-edit', [TaskController::class,'edit']);
$app->router->post('/task-edit', [TaskController::class,'edit']);

$app->run();

