<?php

namespace Maciej\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Maciej\UserBundle\Form\SearchCompanyType;

class CompanyController extends Controller
{

    public function listAction()
    {
        $pageSize = 2;
         $url = '';
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('MaciejStudyBundle:Company');
        $companyFiltered = $repository->findByCriteria($url, 1, $pageSize);

        return $this->render('MaciejUserBundle:Company:list.html.twig', array(
                    'companies' => $companyFiltered,
                    'criteria' => $url,
                    'size' => $pageSize
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
    public function NotFoundAction()
    {
        return $this->render('MaciejUserBundle:Company:NotFound.html.twig');
    }
    
    public function companySearchAction(Request $request)
    {
        $formData = array();
        $form = $this->createForm(SearchCompanyType::class, $formData );

        return $this->render('MaciejUserBundle:Company:searchFormCompany.html.twig', array(
                    'form' => $form->createView()
        ));
    }

}

