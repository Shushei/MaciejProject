<?php
namespace Maciej\MaciejBundle\Service;

class LogoHandler
{
    public function setLogo($em, $gameId, $id)
    {
        $game = $em->getRepository('MaciejStudyBundle:Game')->findOneById($gameId);
        $images = $em->getRepository('MaciejStudyBundle:GameImage')->findByTitle($game);

                foreach($images as $image){
                    if ($image->getId() == $id){
                        $image->setIsLogo('1');
                        $game->setLogoLink($image->getGameImage());
                         $em->persist($image);
                         $em->persist($game);
                    }else{
                        $image->setIsLogo('0');
                        $em->persist($image);
                    }
                }
                
                $em->flush();
    }
    public function getLogo($em, $title)
    {
         $images = $em->getRepository('MaciejStudyBundle:GameImage')->findByTitle($title);
    }
}