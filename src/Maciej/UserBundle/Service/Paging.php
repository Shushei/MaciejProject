<?php
namespace Maciej\UserBundle\Service;

class Paging {
    public function paging($lenght, $size){
        
        $x = (int)($lenght/$size);
        if (($lenght/$size) > $x){
            $pages = $x +1;
        }else{
            $pages = $x;
        }
        
        return $pages;
                
    }
}
