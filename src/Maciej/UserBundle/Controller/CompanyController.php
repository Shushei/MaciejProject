<?php

namespace Maciej\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CompanyController extends Controller
{

    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('MaciejStudyBundle:Company')->findAll();

        return $this->render('MaciejUserBundle:Company:list.html.twig', array(
                    'companies' => $repository
        ));
    }

    public function singleAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id = $request->get('id');
        $company = $em->getRepository('MaciejStudyBundle:Company')->find($id);
        $games = $em->getRepository('MaciejStudyBundle:Game')->findAll();

        return $this->render('MaciejUserBundle:Company:single.html.twig', array(
                    'company' => $company,
                    'games' => $games
        ));
    }

}
