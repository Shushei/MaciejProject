<?php

namespace Maciej\MaciejBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Maciej\MaciejBundle\Form\GameType;
use Maciej\MaciejBundle\Entity\Game;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;


class GameController extends Controller
{

    public function formAction(Request $request)
    {   
        $logger = $this->get('logger');
        
        
        $game = new Game();
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($game);
            $em->flush();
            $logger->info('Added '.$game->getTitle().' to gamelist');

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
        $delete = $request->get('id');
        $game = $em->getRepository('MaciejStudyBundle:Game')->find($delete);
        $em->remove($game);
        $em->flush();
        $logger = $this->get('logger');
        $logger->info('Deleted '.$game->getTitle());
        
        return $this->redirecttoRoute('gamelist');
    }

    public function editAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $edit = $request->get('id');
        $game = $em->getRepository('MaciejStudyBundle:Game')->find($edit);
        $logo = $game->getLogo();
        $fileUploader = $this->get('FileUploader');
        $fileUploader->setTableName('game');
        $url = $fileUploader->listing();

        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            if (empty($game->getLogo()) && !empty($logo)) {
                $game->setLogo($logo);
            } elseif (!empty($game->getLogo()) && !empty($logo)) {
                $fileUploader->delete($logo);
            }

            $em->persist($game);
            $em->flush();


            return $this->redirectToRoute('gamelist');
        }
        return $this->render('MaciejStudyBundle:Game:edit.html.twig', array(
                    'form' => $form->createView(),
                    'game' => $game,
                    'urls' => $url));
    }

    public function deleteimageAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $fileUploader = $this->get('FileUploader');
        $fileUploader->setTableName('game');
        $delete = $request->get('id');
        $game = $em->getRepository('MaciejStudyBundle:Game')->find($delete);
        $logo = $game->getLogo();

        $fileUploader->delete($logo);
        $game->setLogo('');
        $em->persist($game);
        $em->flush();



        return $this->redirectToRoute('gameedit', array('id' => $delete));
    }

}
