<?php

namespace Maciej\MaciejBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Maciej\MaciejBundle\Form\CompanyType;
use Maciej\MaciejBundle\Entity\Company;

class CompanyController extends Controller
{

    public function formAction(Request $request)
    {
        $company = new Company();
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($company);
            $em->flush();

            return $this->redirectToRoute('companylist');
        }
        return $this->render('MaciejStudyBundle:Company:form.html.twig', array('form' => $form->createView()));
    }

    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $fileUploader = $this->get('FileUploader');
        $fileUploader->setTableName('company');
        $repository = $em->getRepository('MaciejStudyBundle:Company')->findAll();

        return $this->render('MaciejStudyBundle:Company:list.html.twig', array('companies' => $repository));
    }

    public function deleteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $delete = $request->get('id');
        $company = $em->getRepository('MaciejStudyBundle:Company')->find($delete);
        $em->remove($company);
        $em->flush();

        return $this->redirecttoRoute('companylist');
    }

    public function editAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $edit = $request->get('id');
        $company = $em->getRepository('MaciejStudyBundle:Company')->find($edit);
        $clogo = $company->getClogo();
        $fileUploader = $this->get('FileUploader');
        $fileUploader->setTableName('company');

        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (empty($company->getClogo()) && !empty($clogo)) {
                $company->setClogo($clogo);
            } elseif (!empty($company->getClogo()) && !empty($clogo)) {
                $fileUploader->delete($clogo);
            }
            $em->persist($company);
            $em->flush();

            return $this->redirectToRoute('companylist');
        }
        return $this->render('MaciejStudyBundle:Company:edit.html.twig', array(
                    'form' => $form->createView(),
                    'company' => $company));
    }

    public function deleteimageAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $fileUploader = $this->get('FileUploader');
        $fileUploader->setTableName('company');
        $delete = $request->get('id');
        $company = $em->getRepository('MaciejStudyBundle:Company')->find($delete);
        $fileName = $company->getFileName();
        $fileUploader->delete($fileName);
        $company->setFileName('');
        $company->setClogo('');
        $em->persist($company);
        $em->flush();

        return $this->redirectToRoute('companyedit', array('id' => $delete));
    }

}
