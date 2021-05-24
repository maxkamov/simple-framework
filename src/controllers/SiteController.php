<?php
/**
 * Created by PhpStorm.
 * User: maxkamov48
 * Date: 5/18/21
 * Time: 9:26 PM
 */

namespace app\controllers;


use app\core\Application;
use app\core\BaseController;
use app\core\dataprovider\DataProvider;
use app\core\Request;
use app\models\entities\Task;
use app\models\entities\User;
use PDO;

class SiteController extends BaseController
{


    public function home(Request $request){

        $queryParams = $request->getBody();

        $query = (new Task())
            ->select(['id','username','text','email','status','updated_by']);


        $dataProvider = new DataProvider(
            $query,
            3,
            $queryParams
        );

        $params = [
            'queryParams' => $dataProvider->getQueryParams(),
            'dataProvider' => $dataProvider
        ];

        return $this->render('home',$params);
    }


}