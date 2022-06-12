<?php

namespace App\Controller;

use App\Entity\Entree;
use App\Entity\Produit;
use App\Form\EntreeType;
use App\Form\ProduitType;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EntreeController extends AbstractController
{
    #[Route('/entree', name: 'app_entree')]
    public function index(PersistenceManagerRegistry $doctrine): Response
    {
        $entree = new Entree();
        $form = $this->createForm(EntreeType::class, $entree, array('action'=>$this->generateUrl('app_addentree')));
        $data['form'] = $form->createView();
        $data['listeEntree'] = $doctrine->getRepository(Entree::class)->findAll();
        return $this->render('entree/index.html.twig', $data);
    }

    #[Route('/addentree', name: 'app_addentree')]
    public function add(PersistenceManagerRegistry $doctrine, Request $request): Response
    {
        $entree = new Entree();
        $form = $this->createForm(EntreeType::class, $entree);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entree->setUtilisateur($this->getUser());
            $entree = $form->getData();
            $db = $doctrine->getManager();
            $db->persist($entree);
            $db->flush();

            $var = $db->getRepository(Produit::class)->find($entree->getProduit()->getId());
            $qte = $var->getQte() + $entree->getQte();
            $var->setQte($qte);
            $db->flush();
        }
        return $this->redirectToRoute('app_entree');
    }

    #[Route('/updateEn', name: 'app_updateEntree')]
    public function update(PersistenceManagerRegistry $doctrine, Request $request): Response
    {
        $db = $doctrine->getManager();
        $e = $db->getRepository(Entree::class)->find($_GET['id']);
        $form = $this->createForm(EntreeType::class, $e);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $e = $form->getData();
            $e->setUtilisateur($this->getUser());
            $db->persist($e);
            $db->flush();
        }
        return $this->redirectToRoute('app_entree');
    }
}
