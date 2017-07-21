<?php

namespace Maciej\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class GameController extends Controller
{

    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $games = $em->getRepository('MaciejStudyBundle:Game')->findAll();
        $data = array('games' => array());
        foreach ($games as $game) {
            $temp = array(
                'company' => $game->getCompany()->getCompany(),
                'title' => $game->getTitle(),
                'date' => $game->getReleaseDate(),
                'logo' => $game->getLogo()
            );
            $data['games'][] = $temp;
        }


        return new JsonResponse($data);
    }

    public function singleAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $game = $em->getRepository('MaciejStudyBundle:Game')->find($id);
        $data = array(
            'company' => $game->getCompany()->getCompany(),
            'title' => $game->getTitle(),
            'date' => $game->getReleaseDate(),
            'logo' => $game->getLogo()
        );
        return new JsonResponse($data);
    }

}
