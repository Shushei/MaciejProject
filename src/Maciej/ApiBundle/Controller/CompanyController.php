<?php

namespace Maciej\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


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
       
        
        return new JsonResponse($data);
    }

    public function singleAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $company = $em->getRepository('MaciejStudyBundle:Company')->find($id);
        $data = array(
            'company' => $company->getCompany(),
            'ownername' => $company->getOwnername(),
            'ownersurname' => $company->getOwnersurname(),
            'founded' => $company->getFounded(),
            'clogo' => $company->getClogo()
        );
         return new JsonResponse($data);
    }

}
