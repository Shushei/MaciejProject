<?php

namespace Maciej\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GameController extends Controller
{

    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $fileUploader = $this->get('FileUploader');
        $urls = $fileUploader->listing();
        $repository = $em->getRepository('MaciejStudyBundle:Game')->findAll();
        $companies = $em->getRepository('MaciejStudyBundle:Company')->findAll();

        return $this->render('MaciejUserBundle:Game:list.html.twig', array(
                    'urls' => $urls,
                    'games' => $repository,
                    'companies' => $companies
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
        $em = $this->getDoctrine()->getManager();
        $fileUploader = $this->get('FileUploader');
        $urls = $fileUploader->listing();
        $repository = $em->getRepository('MaciejStudyBundle:Game');
        $companies = $em->getRepository('MaciejStudyBundle:Company')->findAll();
        $searchCompany = $request->get('searchCompany');
        $searchTitle = $request->get('searchTitle');
        if (!empty($searchTitle)){
        $query = $em->createQuery("SELECT g, c  FROM MaciejStudyBundle:Game g JOIN g.company c
            WHERE g.title = :searchTitle AND 
            c.company  = :searchCompany")
                ->setParameter('searchTitle', $searchTitle)
                ->setParameter('searchCompany', $searchCompany);
        }else{
            $query = $em->createQuery("SELECT g, c  FROM MaciejStudyBundle:Game g JOIN g.company c
            WHERE c.company  = :searchCompany")
                ->setParameter('searchCompany', $searchCompany);
        }
        
       
            $games = $query->getResult();
        

        return $this->render('MaciejUserBundle:Game:list.html.twig', array(
                    'urls' => $urls,
                    'games' => $games,
                    'companies' => $companies
        ));
    }

}
