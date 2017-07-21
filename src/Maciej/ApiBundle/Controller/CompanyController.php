<?php

namespace Maciej\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class CompanyController extends Controller
{

    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $companies = $em->getRepository('MaciejStudyBundle:Company')->findAll();
        $data = array('companies' => array());
        foreach ($companies as $company) {
            $temp = array(
                'company' => $company->getCompany(),
                'ownername' => $company->getOwnername(),
                'ownersurname' => $company->getOwnersurname(),
                'founded' => $company->getFounded(),
                'clogo' => $company->getClogo()
            );
            $data['companies'][] = $temp;
        }
        $response = new Response(json_encode($data), 200);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function singleAction(Request $request)
    {
        $wild = $request->get('wild');
        $em = $this->getDoctrine()->getManager();
        $company = $em->getRepository('MaciejStudyBundle:Company')->find($wild);
        $data = array(
            'company' => $company->getCompany(),
            'ownername' => $company->getOwnername(),
            'ownersurname' => $company->getOwnersurname(),
            'founded' => $company->getFounded(),
            'clogo' => $company->getClogo()
        );
        $response = new Response(json_encode($data), 200);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

}
