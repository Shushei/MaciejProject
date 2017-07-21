<?php

namespace Maciej\Api2Bundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use JMS\Serializer\SerializationContext;

class CompanyController extends FOSRestController
{

    public function getAction()
    {
        $context = SerializationContext::create()->setGroups(array(
            'Default'));
        $em = $this->getDoctrine()->getManager();
        $serializer = $this->get('jms_serializer');
        $companies = $em->getRepository('MaciejStudyBundle:Company')->findAll();
        if ($companies == null) {
            return new View("There exists no companies", Response::HTTP_NOT_FOUND);
        }
        $companies2 = $serializer->serialize($companies, 'json', $context);
        return $companies2;
    }

    public function idAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $company = $em->getRepository('MaciejStudyBundle:Company')->find($id);
        $serializer = $this->get('jms_serializer');
        if ($company == null) {
            return new View("There exists no companies", Response::HTTP_NOT_FOUND);
        }
        $companyview = $serializer->serialize($company, 'json');
        return $companyview;
    }

}
