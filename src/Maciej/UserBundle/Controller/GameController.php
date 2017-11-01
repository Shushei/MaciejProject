<?php

namespace Maciej\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Maciej\UserBundle\Form\SearchGameType;

class GameController extends Controller
{

    public function listAction(Request $request)
    {
        $pageSize = 2;
        $em = $this->getDoctrine()->getManager();
        $url = '';
        $games = $em->getRepository('MaciejStudyBundle:Game');
        $gamesFiltered = $games->findByCriteria($url, 1, $pageSize);

        return $this->render('MaciejUserBundle:Game:list.html.twig', array(
                    'games' => $gamesFiltered,
                    'criteria' => $url,
                    'size' => $pageSize
        ));
    }

    public function singleAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id = $request->get('id');
        $Game = $em->getRepository('MaciejStudyBundle:Game')->find($id);
        $gamesimages = $em->getRepository('MaciejStudyBundle:GameImage')->findAll();

        return $this->render('MaciejUserBundle:Game:single.html.twig', array(
                    'game' => $Game,
        ));
    }

    public function gameSearchAction(Request $request)
    {
        $formData = array();
        $form = $this->createForm(SearchGameType::class, $formData );

        return $this->render('MaciejUserBundle:Game:searchFormGame.html.twig', array(
                    'form' => $form->createView()
        ));
    }

}
