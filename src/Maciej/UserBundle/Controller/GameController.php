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
        $fileUploader = $this->get('FileUploader');
        $paging = $this->get('Paging');
        $urls = $fileUploader->listing();
        $url = '';
        $url = $request->get('url');
        $page = $request->get('pagee');
        $games = $em->getRepository('MaciejStudyBundle:Game');
        $gamesFiltered = $games->findByCriteria($url, $page, $pageSize);
        $gamesCounted = $games->countByCriteria($url, $page, $pageSize);
        $pages = $paging->paging($gamesCounted, $pageSize);


        return $this->render('MaciejUserBundle:Game:list.html.twig', array(
                    'urls' => $urls,
                    'games' => $gamesFiltered,
                    'pages' => $pages,
                    'criteria' => $url,
        ));
    }

    public function singleAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $fileUploader = $this->get('FileUploader');
        $urls = $fileUploader->listing();
        $id = $request->get('id');
        $Game = $em->getRepository('MaciejStudyBundle:Game')->find($id);
        $gamesimages = $em->getRepository('MaciejStudyBundle:GameImage')->findAll();

        return $this->render('MaciejUserBundle:Game:single.html.twig', array(
                    'urls' => $urls,
                    'Game' => $Game,
                    'gameimages' => $gamesimages
        ));
    }

    public function searchAction(Request $request)
    {
        $formData = array();
        $form = $this->createForm(SearchGameType::class, $formData, array(
            'action' => $this->generateUrl('usergamesearch')
        ));
        $pagee = $request->get('pagee');
        $url = $request->get('url');
        $form->handleRequest($request);
        if ($form->isSubmitted() OR !empty($url) OR !empty($pagee)) {
            $searchData = $form->getData();
            if (!empty($searchData['searchTitle'])) {
                $url['title'] = $searchData['searchTitle'];
            }
            if (!empty($searchData['searchCompany'])) {
                $url['company'] = $searchData['searchCompany']->getCompany();
            }
            if (!empty($searchData['minDate'])) {
                $url['minDate'] = $searchData['minDate'];
            }
            if (!empty($searchData['maxDate'])) {
                $url['maxDate'] = $searchData['maxDate'];
            }

            if (!empty($url)) {
                return $this->redirectToRoute('usergamelist', array('url' => $url,
                            'pagee' => $pagee,
                ));
            } else {
                return $this->redirectToRoute('usergamelist', array(
                            'pagee' => $pagee));
            }
        }
        return $this->render('MaciejUserBundle:Game:searchFormGame.html.twig', array(
                    'form' => $form->createView()
        ));
    }

}
