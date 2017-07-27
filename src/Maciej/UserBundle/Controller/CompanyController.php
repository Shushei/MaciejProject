<?php
namespace Maciej\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CompanyController extends Controller
{
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
         $fileUploader = $this->get('FileUploader');
         $urls = $fileUploader->listing();
         $repository = $em->getRepository('MaciejStudyBundle:Company')->findAll();
         
         return $this->render('MaciejUserBundle:Company:list.html.twig', array(
             'urls'=>$urls,
             'companies'=>$repository
                 ));
    }
    public function singleAction(Request $request)
    {$em = $this->getDoctrine()->getManager();
         $fileUploader = $this->get('FileUploader');
         $urls = $fileUploader->listing();
         $id = $request->get('id');
         $company = $em->getRepository('MaciejStudyBundle:Company')->find($id);
         $games = $em->getRepository('MaciejStudyBundle:Game')->findAll();
         
         return $this->render('MaciejUserBundle:Company:single.html.twig', array(
             'urls'=>$urls,
             'company'=>$company,
                 'games'=>$games
                 ));
        
    }
   
    
}

