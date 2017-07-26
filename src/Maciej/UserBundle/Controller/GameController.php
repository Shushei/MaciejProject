<?php

namespace Maciej\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Maciej\UserBundle\Form\SearchGameType;

class GameController extends Controller
{

    public function listAction(Request $request)
    {   $formData = array();
        $form = $this->createForm(SearchGameType::class, $formData);
        $em = $this->getDoctrine()->getManager();
        $fileUploader = $this->get('FileUploader');
        $paging = $this->get('Paging');
        $urls = $fileUploader->listing();
        $url = '';
        $url = $request->get('url');
        $page = $request->get('pagee');
        $gamesFiltered = $em->getRepository('MaciejStudyBundle:Game')->findByCriteria($url, $page);
        $companies = $em->getRepository('MaciejStudyBundle:Company')->findAll();
        $pages = $paging->paging($gamesFiltered['count']);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            return $this->redirectToRoute('usergamesearch', ['request' => $request], 307);
        }

        return $this->render('MaciejUserBundle:Game:list.html.twig', array(
                    'urls' => $urls,
                    'games' => $gamesFiltered['result'],
                    'companies' => $companies,
                    'pages' => $pages,
                    'criteria' => $url,
                    'form' => $form->createView()
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
        $searchData = $request->get('search_game');
        $pagee = $request->get('pagee');
        $url = $request->get('url');
        if (!empty($searchData['searchTitle'])) {
            $url['title'] = $searchData['searchTitle'];
        }
        if (!empty($searchData['searchCompany'])) {
            $url['company'] = $searchData['searchCompany'];
        }
        if (!empty($searchData['minDate'])) {
            $url['minDate'] = $searchData['minDate'];
        }
        if (!empty($searchData['maxDate'])) {
            $url['maxDate'] = $searchData['maxDate'];
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
