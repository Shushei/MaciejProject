<?php
namespace Maciej\MaciejBundle\Service;

class LogoHandler
{
    public function setLogo($em, $title, $id)
    {
        $images = $em->getRepository('MaciejStudyBundle:GameImage')->findByTitle($title);
                foreach($images as $image){
                    $imageid = $image->getId();
                    if ($image->getId() == $id){
                        $image->setIsLogo('1');
                         $em->persist($image);
                    }else{
                        $image->setIsLogo('0');
                        $em->persist($image);
                    }
                }
                
                $em->flush();
    }
}