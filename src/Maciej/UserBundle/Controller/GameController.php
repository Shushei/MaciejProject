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
         
         return $this->render('MaciejUserBundle:Game:list.html.twig', array(
             'urls'=>$urls,
             'games'=>$repository
                 ));
    }
    public function singleAction(Request $request)
    {$em = $this->getDoctrine()->getManager();
         $fileUploader = $this->get('FileUploader');
         $urls = $fileUploader->listing();
         $name = $request->get('name');
         $Game = $em->getRepository('MaciejStudyBundle:Game')->findOneByTitle($name);
         $gamesimages = $em->getRepository('MaciejStudyBundle:GameImage')->findAll();
         
         return $this->render('MaciejUserBundle:Game:single.html.twig', array(
             'urls'=>$urls,
             'Game'=>$Game,
                 'gameimages'=>$gamesimages
                 ));
        
    }
}

