<?php

namespace Maciej\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MaciejApiBundle:Default:index.html.twig');
    }
}
