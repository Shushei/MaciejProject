<?php

namespace Maciej\Api2Bundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\HttpFoundation\Request;

class CompanyController extends FOSRestController
{

    /**
     * 
     * @View(serializerGroups={"Default"})
     */
    public function getlistAction()
    {

        $em = $this->getDoctrine()->getManager();
        $companies = $em->getRepository('MaciejStudyBundle:Company')->findAll();
        if ($companies == null) {
            return new View("There exists no companies", Response::HTTP_NOT_FOUND);
        }

        return $companies;
    }

    /**
     * 
     * @View(serializerGroups={"list", "Default"})
     * 
     */
    public function getCompanyAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $company = $em->getRepository('MaciejStudyBundle:Company')->find($id);
      
        if ($company == null) {
            return new View("There exists no companies", Response::HTTP_NOT_FOUND);
        }
        
        return $company;
    }
  /**
     * 
     * @View(serializerGroups={"Default", "list"})
     */
    public function getListByCriteriaAction(Request $request)
    {   
        $page =   $request->get('page');
        $criteria =  $request->get('criteria');
        $size =  $request->get('size');
        $em = $this->getDoctrine()->getManager();
        $companyFiltered= $em->getRepository('MaciejStudyBundle:Company')->findByCriteria($criteria, $page, $size);
        if ($companyFiltered == null){
            return new View("There are no companies", Response::HTTP_NOT_FOUND);
        }
        return $companyFiltered;
        
    }
}
