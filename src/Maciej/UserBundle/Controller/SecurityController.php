<?php
namespace Maciej\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Maciej\MaciejBundle\Entity\User;
use Maciej\MaciejBundle\Form\UserType;


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
    public function registerAction(Request $request)
    {
        $passwordEncoder = $this->get('security.password_encoder');
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setRoles('ROLE_USER');
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            
            return $this->redirectToRoute('usergamelist');
        }
        return $this->render('MaciejUserBundle:Security:register.html.twig', array('form' => $form->createView()));
    }
}
