<?php
namespace Maciej\Api2Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;

class GameController extends FOSRestController
{
    public function getAction()
    {
        $em = $this->getDoctrine()->getManager();
        $games = $em->getRepository('MaciejStudyBundle:Game')->findAll();
        if ($games == null){
            return new View("There exists no companies", Response::HTTP_NOT_FOUND);
        }
        return $games;
    }
    public function idAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $game = $em->getRepository('MaciejStudyBundle:Game')->find($id);
        if ($game == null){
            return new View("There exists no companies", Response::HTTP_NOT_FOUND);
        }
        return $game;
    }
}