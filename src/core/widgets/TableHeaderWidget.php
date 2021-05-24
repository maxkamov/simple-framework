<?php
/**
 * Created by PhpStorm.
 * User: maxkamov48
 * Date: 5/20/21
 * Time: 11:57 PM
 */

namespace app\core\widgets;


class TableHeaderWidget
{

    public $label;

    public $column_name;

    public $column_sort_value;

    public $queryParams;

    public function __construct($params)
    {

        $this->label = $params['label'];
        $this->queryParams = $params['queryParams'];
        $this->column_name = $params['column_name'];
        $this->column_sort_value = strtolower($this->column_name);
        $sorted_column_name = strtolower($this->queryParams['sort']);




        if($this->equalsToSame($sorted_column_name)){

            if($this->currentArrowIsUp()){
                $this->prependDash();
            }else{
                $this->removeDash();
            }

//            echo "<pre>";
//            print_r($this);
//            echo "Same";
//            die;

        }

//        else if($this->equalsToReverse($sorted_column_name)){
//            echo "<pre>";
//            print_r($this);
//            echo "Diff";
//            die;
//            if($this->currentArrowIsUp()){
//                $this->prependDash();
//            }else{
//                $this->removeDash();
//            }
//        }



//        echo "<pre>";
//        var_dump($this->equalsToReverse($sorted_column_name));
//
//        echo "<pre>";
//        print_r($sorted_column_name);
//
//        echo "<pre>";
//        print_r($this);
//        die;

//        if(array_key_exists('sort',$this->queryParams) ){



//            echo "<pre>";
//            print_r($sorted_column_name);
//            die;


//            if($this->equalsToSame($sorted_column_name)){
//                if($this->currentArrowIsUp()){
//                    $this->prependDash();
//                }else{
//                    $this->removeDash();
//                }
//            }else if($this->equalsToReverse($sorted_column_name)){
//                if($this->currentArrowIsUp()){
//                    $this->prependDash();
//                }else{
//                    $this->removeDash();
//                }
//            }
//
//
//        }else{
//            $this->column_sort_value = strtolower($this->column_name);
//        }
//        echo "J";
//        echo "<pre>";
//        var_dump($this->equalsToSame($sorted_column_name));
//        echo "J";
//        die;


    }




    public function getLink()
    {
        $url = "?page=".$this->queryParams['page']."&sort=".$this->column_sort_value;
        return $url;
    }

    private function getClass()
    {
        if($this->currentArrowIsUp()){
            return "glyphicon glyphicon-triangle-top";
        }else{
            return "glyphicon glyphicon-triangle-bottom";
        }

    }

    public function getColumnName()
    {
        return $this->column_name;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function run(){
        echo '<th><a href="'.$this->getLink().'"><span class="'.$this->getClass().'"></span> '.$this->getLabel().'</a></th>';
    }








    private function equalsToReverse($value)
    {
        $removed_first_character = substr($value,1);
        if($removed_first_character == $this->column_sort_value){
            return true;
        }

        $removed_first_character = substr($this->column_sort_value,1);
        if($removed_first_character == $value){
            return true;
        }

        return false;
    }

    private function equalsToSame($value)
    {
        if($this->column_sort_value == $value){
            return true;
        }
        return false;
    }

    private function currentArrowIsUp(){
        $first_char = mb_substr($this->column_sort_value, 0, 1);
        if($first_char == '-'){
            return false;
        }
        return true;
    }

    private function prependDash()
    {
        $this->column_sort_value = "-".$this->column_sort_value;
    }

    private function removeDash()
    {
        $this->column_sort_value = substr($this->column_sort_value,1);
    }

}