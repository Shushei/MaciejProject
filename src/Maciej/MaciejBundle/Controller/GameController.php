<?php

namespace Maciej\MaciejBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Maciej\MaciejBundle\Form\GameType;
use Maciej\MaciejBundle\Entity\Game;

class GameController extends Controller
{

    public function formAction(Request $request)
    {
        $game = new Game();
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($game);
            $em->flush();


            return $this->redirectToRoute('gamelist');
        }
        return $this->render('MaciejStudyBundle:Game:form.html.twig', array('form' => $form->createView()));
    }

    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('MaciejStudyBundle:Game')->findAll();

        return $this->render('MaciejStudyBundle:Game:list.html.twig', array('games' => $repository));
    }

    public function deleteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $delete = $request->get('wild');
        $game = $em->getRepository('MaciejStudyBundle:Game')->find($delete);
        $em->remove($game);
        $em->flush();

        return $this->redirecttoRoute('gamelist');
    }

    public function editAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $edit = $request->get('wild');
        $game = $em->getRepository('MaciejStudyBundle:Game')->find($edit);
        $logo = $game->getLogo();

        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);


        if ($form->isSubmitted() && ($form->isValid() OR empty($logo))) {
            if($logo != $game->getLogo() && !empty($logo)){
                $game->setLogo($logo);
            }
          
            $em->persist($game);
            $em->flush();


            return $this->redirectToRoute('gamelist');
        }
        return $this->render('MaciejStudyBundle:Game:edit.html.twig', array('form' => $form->createView(), 'game' => $game));
    }

    public function deleteimageAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $fileUploader = $this->get('FileUploader');
        $fileUploader->setTableName('game');
        $delete = $request->get('wild');
        $game = $em->getRepository('MaciejStudyBundle:Game')->find($delete);
        $logo = $game->getLogo();
        $logoName = $logo->getFilename();
        $fileUploader->delete($logoName);
        $game->setLogo('');
        $em->persist($game);
        $em->flush();



        return $this->redirectToRoute('gameedit', array('wild' => $delete));
    }

}
