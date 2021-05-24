<?php
/**
 * Created by PhpStorm.
 * User: maxkamov48
 * Date: 5/20/21
 * Time: 2:21 PM
 */

namespace app\controllers;


use app\core\Application;
use app\core\BaseController;
use app\core\Request;
use app\models\entities\Task;
use app\models\forms\TaskCreateForm;

class TaskController extends BaseController
{

    public function create(Request $request){
        $createForm = new TaskCreateForm();

        if($request->isPost() ){
            $createForm->loadData($request->getBody());

            if( $createForm->validate() ){

                $model = new Task();
                $model->username = $createForm->username;
                $model->email = $createForm->email;
                $model->text = $createForm->text;
                $model->updated_by = "";
                $model->status = Task::OPEN;
                $model->save();

                Application::$app->session->setFlash('success', 'Новая задача успешно создана');
                Application::$app->response->redirect('/home');

            }

        }

        return $this->render('task-create',[
            'model' => $createForm
        ]);
    }

    public function edit(Request $request){

        if(Application::isGuest()){
            Application::$app->session->setFlash('error', 'Пожалуйста, войдите, чтобы редактировать задачу');
            Application::$app->response->redirect('/login');
        }

        $id = $request->getBody()['id'];

        $model = $this->findOne($id);

        if($request->isPost()){

            if(Application::isGuest()){
                Application::$app->session->setFlash('error', 'Пожалуйста, войдите, чтобы редактировать задачу');
                Application::$app->response->redirect('/login');
            }else{

                $model->loadData($request->getBody());

                $model->updated_by = "Admin";
                if($request->getBody()['status'] == "on"){
                    $model->status = Task::FINISHED;
                }else {
                    $model->status = Task::OPEN;
                }


                if($model->validate()){
                    $model->update();
                    Application::$app->session->setFlash('success', 'Задача успешно отредактирована администратором');
                    Application::$app->response->redirect('/home');
                }

            }

        }

        return $this->render('task-edit',[
            'model'=>$model
        ]);
    }

    public function findOne($id): Task
    {
        $model = (new \app\models\entities\Task)->findByPk($id);

        if(!empty($model)){
            return $model;
        }

        throw new \DomainException('Task with id = '.$id.' not found!');
    }
}