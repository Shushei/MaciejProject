<?php

namespace Maciej\MaciejBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MaciejStudyBundle:Default:index.html.twig');
    }
}
