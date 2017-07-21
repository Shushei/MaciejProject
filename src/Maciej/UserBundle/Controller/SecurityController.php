<?php
namespace Maciej\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    public function loginAction(Request $request)
    {
      $authUtils = $this->get('security.authentication_utils');
        $error = $authUtils->getLastAuthenticationError();
        
        $lastUsername = $authUtils->getLastUsername();
        
        return $this->render('MaciejUserBundle:Security:login.html.twig', array(
            'last_username' => $lastUsername,
            'error' => $error
        ));
    }
}
