<?php

namespace Maciej\MaciejBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Maciej\MaciejBundle\Form\GameImageType;
use Maciej\MaciejBundle\Entity\GameImage;

class GameImageController extends Controller
{

    public function formAction(Request $request)
    {
        $GameImage = new GameImage();
        $form = $this->createForm(GameImageType::class, $GameImage);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $games = $em->getRepository('MaciejStudyBundle:Game')->findall();

        if ($form->isSubmitted() && $form->isValid()) {
            if ($GameImage->getIsLogo() == 1) {
                $id = $GameImage->getId();
                $title = $GameImage->getTitle();
                $logohandler = $this->get('LogoHandler');
                $images = $logohandler->setLogo($em, $title, $id);        
            }
            
            $em->persist($GameImage);
            $em->flush();

            return $this->redirectToRoute('gameimageform', array('games' => $games));
        }
        return $this->render('MaciejStudyBundle:GameImage:form.html.twig', array('form' => $form->createView(), 'games' => $games));
    }

    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('MaciejStudyBundle:GameImage')->findAll();
        $games = $em->getRepository('MaciejStudyBundle:Game')->findall();
        $title = $request->get('title');
        $game1 = $em->getRepository('MaciejStudyBundle:Game')->findOneByTitle($title);



        return $this->render('MaciejStudyBundle:GameImage:list.html.twig', array(
                    'images' => $repository,
                    'title' => $title,
                    'games' => $games,
        ));
    }

    public function deleteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $delete = $request->get('id');
        $GameImage = $em->getRepository('MaciejStudyBundle:GameImage')->find($delete);
        $title = $GameImage->getTitle()->getTitle();
        $em->remove($GameImage);
        $em->flush();

        return $this->redirecttoRoute('gameimagelist', array('id' => $title));
    }

    public function editAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $edit = $request->get('id');
        $GameImage = $em->getRepository('MaciejStudyBundle:GameImage')->find($edit);
        $image = $GameImage->getGameImage();

        $form = $this->createForm(GameImageType::class, $GameImage);
        $form->handleRequest($request);


        if ($form->isSubmitted() && ($form->isValid() OR empty($image))) {
            if ($image != $GameImage->getGameImage() && !empty($image)) {
                $GameImage->setGameImage($image);
            }

            $em->persist($GameImage);
            $em->flush();


            return $this->redirectToRoute('GameImagelist');
        }
        return $this->render('MaciejStudyBundle:GameImage:edit.html.twig', array(
                    'form' => $form->createView(),
                    'GameImage' => $GameImage));
    }

    public function deleteimageAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $fileUploader = $this->get('FileUploader');
        $fileUploader->setTableName('gameimage');
        $delete = $request->get('id');
        $GameImage = $em->getRepository('MaciejStudyBundle:GameImage')->find($delete);
        $image = $GameImage->getGameImage();
        $GameImageName = $image->getFilename();
        $fileUploader->delete($GameImageName);
        $GameImage->setGameImage('');
        $em->persist($GameImage);
        $em->flush();



        return $this->redirectToRoute('GameImageedit', array('id' => $delete));
    }
    public function setLogoAction(Request $request)
    {
        $id = $request->get('id');
        $gameId = $request->get('gameId');
        $logohandler = $this->get('LogoHandler');
        $em = $this->getDoctrine()->getManager();
        $game = $em->getRepository('MaciejStudyBundle:Game')->findOneById($gameId);
        $logohandler->setLogo($em, $game, $id);
        $games = $em->getRepository('MaciejStudyBundle:Game')->findAll();
        $title = $game->getTitle();
        
        return $this->redirectToRoute('gameimagelist', array(
            'title' =>$title,
            'games' =>$games
        ));
    }

}
