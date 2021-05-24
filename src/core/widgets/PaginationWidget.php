<?php
/**
 * Created by PhpStorm.
 * User: maxkamov48
 * Date: 5/20/21
 * Time: 6:39 PM
 */

namespace app\core\widgets;


class PaginationWidget
{

    private $total_pages;

    private $limit = 3;

    private $current_page;

    private $queryParams;



    public function __construct($total_records, $records_per_page, $current_page = 1, $queryParams)
    {
        $this->total_pages = ceil($total_records / $records_per_page);
        $this->limit = $records_per_page;
        $this->current_page = $current_page;
        $this->queryParams = $queryParams;
    }

    private function previousLink()
    {
        $data = '<li>
                <a href="'.$this->getUrlPrevious().'" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>';

        return $data;
    }

    private function nextLink()
    {
        $data = '<li>
                <a href="'.$this->getUrlNext().'" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>';

        return $data;
    }


    private function generateLinkWithSort($page)
    {
        $url = "?page=".$page."&sort=".$this->queryParams['sort'];
        return $url;
    }


    private function middleLinks()
    {
        $data = "";
        for($i = 1; $i <= $this->total_pages; $i++){

            if($this->current_page == $i){
                $active = "active";
            }else{
                $active = "";
            }

            $data .= '<li class="'.$active.'"><a href="'.$this->generateLinkWithSort($i).'">'.$i.'</a></li>';
        }
        return $data;
    }


    private function getUrlPrevious()
    {

        if($this->current_page == 1){
            return null;
        }
        $page = $this->current_page - 1;

        return $this->generateLinkWithSort($page);
    }

    private function getUrlNext()
    {
        if($this->total_pages == $this->current_page){
            return null;
        }
        $page = $this->current_page + 1;

        return $this->generateLinkWithSort($page);
    }


    private function generateLinks()
    {
        $link = "";
        $link .= $this->previousLink();
        $link .= $this->middleLinks();
        $link .= $this->nextLink();
        return $link;
    }



    public function run()
    {
        $html = "";

        $header = "<nav aria-label=\"Page navigation\">
        <ul class=\"pagination\">";

        $footer = "</ul>
    </nav>";

        $html .= $header;
        $html .= $this->generateLinks();
        $html .= $footer;

        echo $html;
    }

}


