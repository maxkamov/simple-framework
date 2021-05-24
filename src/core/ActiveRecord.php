<?php
/**
 * Created by PhpStorm.
 * User: maxkamov48
 * Date: 5/19/21
 * Time: 9:59 PM
 */

namespace app\core;


use PDO;

class ActiveRecord extends Model
{

    protected $query;

    protected $old_attributes = [];

    protected $dirty_attributes = [];

    public function tableName()
    {

    }

    public function primaryKey()
    {

    }

    public function findByPk($id){
        $tableName = $this::tableName();
        $statement = self::prepare("SELECT * FROM ". $tableName ." WHERE id = :id");
        $statement->bindValue(":id", $id);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if(empty($result)){
            return null;
        }

        $model = new $this();

        if(is_array($result)){
            foreach ($result as $key => $data){
                $model->{$key} = $data;
                $model->old_attributes[$key] = $data;
            }
        }

        return $model;
    }

    public function delete()
    {
        $tableName = $this->tableName();
        $statement = self::prepare("DELETE FROM ". $tableName ." WHERE id = :id");
        $statement->bindValue(":id", $this->id);
        $statement->execute();
    }

    public function update($runValidation = false)
    {
        $tableName = $this->tableName();

        if($runValidation){
            if(!$this->validate()){
                return false;
            }
        }

        foreach ($this->old_attributes as $key => $old){
            if($old != $this->{$key}){
                $this->dirty_attributes[$key] = $this->{$key};
            }
        }

        if(empty($this->dirty_attributes)){
            return true;
        }

        $params = "";

        $numItems = count($this->dirty_attributes);
        $i = 0;

        foreach ($this->dirty_attributes as $key => $val){
            $params .= "$key=:$key".",";

            if(++$i === $numItems) {
                $params .= "$key=:$key";
            }else{
                $params .= "$key=:$key".",";
            }

        }

        $statement = self::prepare("UPDATE  $tableName  SET  $params 
        WHERE id =:id");

        $statement->bindValue(":id", $this->id);
        foreach ($this->dirty_attributes as $key => $attr) {
            $statement->bindValue(":$key", $this->{$key});
        }

        $statement->execute();

        return true;
    }

    public function save($runValidation = false)
    {

        if($runValidation){
            if(!$this->validate()){
                return false;
            }
        }

        $tableName = $this->tableName();
        $attributes = $this->attributes();
        array_unshift($attributes, $this->primaryKey());

        $params = array_map( function ($attr) { return ":$attr"; } , $attributes );
        $statement = self::prepare("INSERT INTO $tableName (" . implode(",", $attributes) . ")
                VALUES (" . implode(",", $params) . ")");
        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }

        $statement->execute();
        return true;
    }



    protected function reset()
    {
        $this->query = new \stdClass();
    }

    public function select($fields)
    {
        $this->reset();
        $this->query->base = "SELECT " . implode(", ", $fields) . " FROM " . $this->tableName();
        $this->query->type = 'select';

        return $this;
    }

    public function where( $field,  $value,  $operator = '=')
    {
        if (!in_array($this->query->type, ['select', 'update', 'delete'])) {
            throw new \Exception("WHERE can only be added to SELECT, UPDATE OR DELETE");
        }
        $this->query->where[] = "$field $operator '$value'";

        return $this;
    }

    public function limit( $start,  $offset)
    {
        if (!in_array($this->query->type, ['select'])) {
            throw new \Exception("LIMIT can only be added to SELECT");
        }
        $this->query->limit = " LIMIT " . $start . ", " . $offset;

        return $this;
    }


    public function orderBy( $order )
    {

        $this->query->order = " ORDER BY " . $order;


        return $this;
    }



    public function getSQL()
    {
        $query = $this->query;
        $sql = $query->base;
        if (!empty($query->where)) {
            $sql .= " WHERE " . implode(' AND ', $query->where);
        }
        if (isset($query->order)) {
            $sql .= $query->order;
        }
        if (isset($query->limit)) {
            $sql .= $query->limit;
        }

        $sql .= ";";
        return $sql;
    }

    public function getAllAsArray()
    {

        $sql = $this->getSQL();

        $preparedData = Application::$app->db->prepare($sql);
        $preparedData->execute();
        $result = $preparedData->fetchAll(PDO::FETCH_ASSOC);

        return $result;

    }

    public function getAsArray()
    {
        $query = $this->query;
        $sql = $query->base;
        if (!empty($query->where)) {
            $sql .= " WHERE " . implode(' AND ', $query->where);
        }
        if (isset($query->limit)) {
            $sql .= $query->limit;
        }
        $sql .= ";";
        $preparedData = Application::$app->db->prepare($sql);
        $preparedData->execute();
        $result = $preparedData->fetch(PDO::FETCH_ASSOC);



        return $result;
    }

    public static function prepare($sql)
    {
        return Application::$app->db->prepare($sql);
    }
}