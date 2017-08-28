<?php

namespace Maciej\Api2Bundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\View;
use JMS\Serializer\SerializationContext;

class GameImageController extends FOSRestController
{


    /**
     * 
     * @View(serializerGroups={"Default", "images"})
     */
    public function getImagesByTitleAction(Request $request)
    {   
        $title =   $request->get('title');
        $em = $this->getDoctrine()->getManager();
        $gameImages= $em->getRepository('MaciejStudyBundle:GameImage')->findByGameTitle($title);
        if ($gameImages == null){
            return new View("There exists no companies", Response::HTTP_NOT_FOUND);
        }
        return $gameImages;
        
    }
}