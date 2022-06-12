<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{
    #[Route('/produit', name: 'app_produit')]
    public function index(PersistenceManagerRegistry $doctrine): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit, array('action'=>$this->generateUrl('app_add')));
        $data['form'] = $form->createView();
        $data['listeProduit'] = $doctrine->getRepository(Produit::class)->findAll();

        return $this->render('produit/liste.html.twig', $data);
    }

    #[Route('/add', name: 'app_add')]
    public function add(PersistenceManagerRegistry $doctrine, Request $request): Response
    {

        $produit = new Produit();

        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ){
            $produit = $form->getData();
            //$u = $this->getUser();
            $produit->setUtilisateur($this->getUser());
            $db = $doctrine->getManager();
            $db->persist($produit);
            $db->flush();
        }
        return $this->redirectToRoute('app_produit');
    }


    #[Route('/updatePro', name: 'app_updateProduit')]
    public function update(PersistenceManagerRegistry $doctrine, Request $request): Response
    {
        $db = $doctrine->getManager();
        $p = $db->getRepository(Produit::class)->find($_GET['id']);
        $form = $this->createForm(ProduitType::class, $p);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $p = $form->getData();
            $p->setUtilisateur($this->getUser());
            $db->persist($p);
            $db->flush();
        }
        return $this->redirectToRoute('app_produit');
    }


    #[Route('/deleteProduit', name: 'app_deleteProduit')]
    public function delete(PersistenceManagerRegistry $doctrine, Request $request): Response
    {
        $id = $_GET['id'];
        $db = $doctrine->getManager();
        $p = $db->getRepository(Produit::class)->find($id);
        $db->remove($p);
        $db->flush();

        return $this->redirectToRoute('app_produit');
    }
}
