<?php

namespace Maciej\Api2Bundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use JMS\Serializer\SerializationContext;

class GameController extends FOSRestController
{

    public function getlistAction()
    {
        $context = SerializationContext::create()->setGroups(array(
            'Default'
        ));
        $em = $this->getDoctrine()->getManager();
        $games = $em->getRepository('MaciejStudyBundle:Game')->findAll();
        $serializer = $this->get('jms_serializer');
        if ($games == null) {
            return new View("There exists no companies", Response::HTTP_NOT_FOUND);
        }
        $gamesview= $serializer->serialize($games,'json', $context);
        return $gamesview;
    }

    public function getGameAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $game = $em->getRepository('MaciejStudyBundle:Game')->find($id);
        if ($game == null) {
            return new View("There exists no companies", Response::HTTP_NOT_FOUND);
        }
         $serializer = $this->get('jms_serializer');
           $gameview= $serializer->serialize($game,'json');
        return $gameview;
    }

}
