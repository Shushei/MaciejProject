<?php

namespace Maciej\Api2Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;

class CompanyController extends FOSRestController
{
    public function getAction()
    {
        $em = $this->getDoctrine()->getManager();
        $companies = $em->getRepository('MaciejStudyBundle:Company')->findAll();
        if ($companies == null){
            return new View("There exists no companies", Response::HTTP_NOT_FOUND);
        }
        return $companies;
    }
    public function idAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $company = $em->getRepository('MaciejStudyBundle:Company')->find($id);
        if ($company == null){
            return new View("There exists no companies", Response::HTTP_NOT_FOUND);
        }
        return $company;
    }
}


