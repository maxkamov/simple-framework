<?php
/**
 * Created by PhpStorm.
 * User: maxkamov48
 * Date: 5/20/21
 * Time: 9:42 PM
 */

namespace app\core\dataprovider;


use app\core\ActiveRecord;

class DataProvider
{

    public $query;

    public $queryParams;

    public $data;

    public $pageSize;

    public $page;

    public $sort;

    public $total_records;

    public function __construct(ActiveRecord $query, $pageSize, $queryParams)
    {

        if(!array_key_exists('page',$queryParams)){
            $queryParams['page'] = 1;
        }

        if(!array_key_exists('sort',$queryParams)){
            $queryParams['sort'] = "id";
        }

        $this->queryParams = $queryParams;
        $this->page = $queryParams['page'];
        $this->sort = $queryParams['sort'];

        if(empty($this->page)){
            throw new \DomainException('Page number must be set');
        }

        $this->query = $query;

        $this->pageSize = $pageSize;
    }

    private function prepare()
    {
        $this->data = $this->query
            ->orderBy($this->sort)
            ->limit($this->paginate($this->page), $this->pageSize)
            ->getAllAsArray();
    }

    public function getTotalRecords()
    {
        return $this->total_records;
    }

    public function getPageSize()
    {
        return $this->pageSize;
    }

    public function getCurrentPage()
    {
        return $this->page;
    }


    public function getData()
    {
        $this->prepare();
        return $this->data;
    }

    public function getQueryParams()
    {
        return $this->queryParams;
    }


    private function paginate($page)
    {
        $models = $this->query->getAllAsArray();
        $this->total_records = count($models);
        $total_pages = ceil($this->total_records / $this->pageSize);
        if($page > $total_pages){
            throw new \DomainException('Page Does not exist');
        }
        if($page == 1){
            $offset = 0;
        }else{
            $offset = ($page - 1) * $this->pageSize;
        }
        return $offset;
    }



}