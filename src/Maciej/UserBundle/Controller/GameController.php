<?php

namespace Maciej\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GameController extends Controller
{

    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $fileUploader = $this->get('FileUploader');
        $urls = $fileUploader->listing();
        $repository = $em->getRepository('MaciejStudyBundle:Game')->findByCriteria($request);
        $companies = $em->getRepository('MaciejStudyBundle:Company')->findAll();
        $page = $request->get('pagee');
        $url = '';
        $url = $request->get('url');
        $count = 0;
        $pagecount = 1;
        foreach ($repository as $game) {
            $count ++;
            $games[$pagecount][] = $game;
            if ($count / 3 == 1) {
                $count = 0;
                $pagecount = $pagecount + 1;
            }
        }
     
            return $this->render('MaciejUserBundle:Game:list.html.twig', array(
                        'urls' => $urls,
                        'games' => $games[$page],
                        'companies' => $companies,
                        'pages' => $games,
                        'criteria' => $url
            ));
       
    }

    public function singleAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $fileUploader = $this->get('FileUploader');
        $urls = $fileUploader->listing();
        $name = $request->get('name');
        $Game = $em->getRepository('MaciejStudyBundle:Game')->findOneByTitle($name);
        $gamesimages = $em->getRepository('MaciejStudyBundle:GameImage')->findAll();

        return $this->render('MaciejUserBundle:Game:single.html.twig', array(
                    'urls' => $urls,
                    'Game' => $Game,
                    'gameimages' => $gamesimages
        ));
    }

    public function searchAction(Request $request)
    {
        $title = $request->get('searchTitle');
        $company = $request->get('searchCompany');
        $minDate = $request->get('preDate');
        $maxDate = $request->get('postDate');
        $pagee = $request->get('pagee');
        $url = $request->get('url');
        if (!empty($title)) {
            $url['title'] = $title;
        }
        if (!empty($company)) {
            $url['company'] = $company;
        }
        if (!empty($minDate) && !empty(maxDate)) {
            $url['minDate'] = $minDate;
            $url['maxDate'] = $maxDate;
        }

        if (!empty($url)) {
            return $this->redirectToRoute('usergamelist', array('url' => $url,
                        'pagee' => $pagee
            ));
        } else {
            return $this->redirectToRoute('usergamelist', array(
                        'pagee' => $pagee));
        }
    }

}
