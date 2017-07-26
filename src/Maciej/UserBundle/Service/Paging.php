<?php
namespace Maciej\UserBundle\Service;

class Paging {
    public function paging($lenght){
        
        $pages = ((int)$lenght/3)+1;
        
        return $pages;
                
    }
}
