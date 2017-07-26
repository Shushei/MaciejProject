<?php
namespace Maciej\UserBundle\Service;

class Paging {
    public function paging($lenght){
        
        $x = (int)($lenght/3);
        if (($lenght/3) > $x){
            $pages = $x +1;
        }else{
            $pages = $x;
        }
        
        return $pages;
                
    }
}
