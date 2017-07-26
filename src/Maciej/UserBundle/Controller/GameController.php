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
        $paging = $this->get('Paging');
        $urls = $fileUploader->listing();
        $url = '';
        $url = $request->get('url');
        $page = $request->get('pagee');
        $gamesFiltered = $em->getRepository('MaciejStudyBundle:Game')->findByCriteria($url, $page);
        $companies = $em->getRepository('MaciejStudyBundle:Company')->findAll();
       $pages = $paging->paging($gamesFiltered['count']);
        
     
            return $this->render('MaciejUserBundle:Game:list.html.twig', array(
                        'urls' => $urls,
                        'games' => $gamesFiltered['result'],
                        'companies' => $companies,
                        'pages' => $pages,
                        'criteria' => $url
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
        if (!empty($minDate) ) {
            $url['minDate'] = $minDate;
        }
        if (!empty($maxDate) ) {
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
