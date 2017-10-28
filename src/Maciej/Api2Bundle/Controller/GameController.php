<?php

namespace Maciej\Api2Bundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\View;
use JMS\Serializer\SerializationContext;

class GameController extends FOSRestController
{

    /**
     * 
     * @View(serializerGroups={"Default"})
     */
    public function getlistAction()
    {

        $em = $this->getDoctrine()->getManager();
        $games = $em->getRepository('MaciejStudyBundle:Game')->findAll();
        if ($games == null) {
            return new View("There exists no companies", Response::HTTP_NOT_FOUND);
        }
        return $games;
    }

    /**
     * 
     * @View(serializerGroups={"list", "Default"})
     * 
     */
    public function getGameAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $game = $em->getRepository('MaciejStudyBundle:Game')->find($id);
        if ($game == null) {
            return new View("There exists no companies", Response::HTTP_NOT_FOUND);
        }

        return $game;
    }
    /**
     * 
     * @View(serializerGroups={"Default", "list"})
     */
    public function getListByCriteriaAction(Request $request)
    {   
        $page =   $request->get('page');
        $criteria =  $request->get('criteria');
        $size =  $request->get('size');
        $em = $this->getDoctrine()->getManager();
        $gamesFiltered= $em->getRepository('MaciejStudyBundle:Game')->findByCriteria($criteria, $page, $size);
        if ($gamesFiltered == null){
            return new View("There exists no games", Response::HTTP_NOT_FOUND);
        }
        return $gamesFiltered;
        
    }
}
