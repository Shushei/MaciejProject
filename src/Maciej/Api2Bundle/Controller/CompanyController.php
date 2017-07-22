<?php

namespace Maciej\Api2Bundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\View;

class CompanyController extends FOSRestController
{

    /**
     * 
     * @View(serializerGroups={"Default"})
     */
    public function getAction()
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
    public function idAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $company = $em->getRepository('MaciejStudyBundle:Company')->find($id);
      
        if ($company == null) {
            return new View("There exists no companies", Response::HTTP_NOT_FOUND);
        }
        
        return $company;
    }

}
