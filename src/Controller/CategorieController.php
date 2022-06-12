<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Entree;
use App\Form\CategorieType;
use App\Form\EntreeType;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    #[Route('/categorie', name: 'app_categorie')]
    public function index(PersistenceManagerRegistry $doctrine): Response
    {
        $cat = new Categorie();
        $form = $this->createForm(CategorieType::class, $cat , array('action'=>$this->generateUrl('app_addcategorie')));
        $data['form'] = $form->createView();
        $data['listeCategorie'] = $doctrine->getRepository(Categorie::class)->findAll();
        return $this->render('categorie/index.html.twig', $data);
    }

    #[Route('/addcategorie', name: 'app_addcategorie')]
    public function add(PersistenceManagerRegistry $doctrine, Request $request): Response
    {
        $cat = new Categorie();
        $form = $this->createForm(CategorieType::class, $cat);
        $form->handleRequest($request);
        $db = $doctrine->getManager();

        if ($form->isSubmitted() && $form->isValid()){

            $cat = $form->getData();
            //$cat->setUtilisateur($this->getUser());
            $db->persist($cat);
            $db->flush();
        }
        return $this->redirectToRoute('app_categorie');
    }

    #[Route('/updateCat', name: 'app_updateCategorie')]
    public function update(PersistenceManagerRegistry $doctrine, Request $request): Response
    {
        $db = $doctrine->getManager();
        $c = $db->getRepository(Categorie::class)->find($_GET['id']);
        $form = $this->createForm(CategorieType::class, $c);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $e = $form->getData();
            $db->persist($e);
            $db->flush();
        }
        return $this->redirectToRoute('app_categorie');
    }

    #[Route('/deleteCat', name: 'app_deleteCategorie')]
    public function deleteCat(PersistenceManagerRegistry $doctrine, Request $request): Response
    {
        $db = $doctrine->getManager();
        $id = $_GET['id'];
        $c = $db->getRepository(Categorie::class)->find($id);
        $db->remove($c);
        $db->flush();

        return $this->redirectToRoute('app_categorie');
    }

}
