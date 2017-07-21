<?php

namespace Maciej\Api2Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MaciejApi2Bundle:Default:index.html.twig');
    }
}
