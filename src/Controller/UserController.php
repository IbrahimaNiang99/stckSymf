<?php

namespace App\Controller;

use App\Entity\Entree;
use App\Entity\User;
use App\Form\EntreeType;
use App\Form\UserType;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(PersistenceManagerRegistry $doctrine): Response
    {
        $u = new User();
        $form = $this->createForm(UserType::class, $u, array('action'=>$this->generateUrl('app_addUser')));
        $data['form'] = $form->createView();
        $data['listeUser'] = $doctrine->getRepository(User::class)->findAll();
        return $this->render('user/index.html.twig', $data);
    }

    #[Route('/adduser', name: 'app_addUser')]
    public function add(PersistenceManagerRegistry $doctrine, Request $request, UserPasswordHasherInterface $hasher): Response
    {
        $u = new User();
        $form = $this->createForm(UserType::class, $u);
        $form->handleRequest($request);
        $db = $doctrine->getManager();

        if ($form->isSubmitted() && $form->isValid()){

            $u = $form->getData();
            $mdp = $hasher->hashPassword($u, "passer");
            $u->setUtilisateur($this->getUser());

            $u->setPassword($mdp);
            $db->persist($u);
            $db->flush();
        }
        return $this->redirectToRoute('app_user');
    }

    #[Route('/updateUser', name: 'app_updateUser')]
    public function update(PersistenceManagerRegistry $doctrine, Request $request): Response
    {
        $db = $doctrine->getManager();
        $u = $db->getRepository(User::class)->find($_GET['id']);
        $form = $this->createForm(UserType::class, $u);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $u = $form->getData();
            $u->setUtilisateur($this->getUser());
            $db->persist($u);
            $db->flush();
        }
        return $this->redirectToRoute('app_addUser');
    }
}
