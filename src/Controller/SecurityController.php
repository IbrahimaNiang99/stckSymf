<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use ContainerCNxhi6R\getSecurity_UserPasswordHasherService;

class SecurityController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->redirectToRoute('app_login');
    }


    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, UserPasswordHasherInterface $hasher): Response
    {
        //$u = new User();
        //$mdp = $hasher->hashPassword($u, "passer");
         if ($this->getUser()) {
              //if ($this->getUser()->getPassword() == $mdp){
                  //$sms['sms'] = "Changer de mot de passe";
                  //return $this->redirectToRoute('app_login');
                  //return $this->render('security/login.html.twig', $sms);
              //}else{
                  return $this->redirectToRoute('app_produit');
             // }
             //var_dump($this->getUser());

             //return $this->redirectToRoute('app_produit');
         }


        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
