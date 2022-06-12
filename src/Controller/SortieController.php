<?php

namespace App\Controller;

use App\Entity\Entree;
use App\Entity\Produit;
use App\Entity\Sortie;
use App\Form\EntreeType;
use App\Form\SortieType;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends AbstractController
{
    #[Route('/sortie', name: 'app_sortie')]
    public function index(PersistenceManagerRegistry $doctrine): Response
    {
        $sortie = new Sortie();
        $form =$this->createForm(SortieType::class, $sortie, array('action'=>$this->generateUrl('app_addsortie')));
        $data['form'] = $form->createView();
        $data['listeSortie'] = $doctrine->getRepository(Sortie::class)->findAll();
        return $this->render('sortie/index.html.twig', $data);
    }

    #[Route('/addsortie', name: 'app_addsortie')]
    public function add(PersistenceManagerRegistry $doctrine, Request $request): Response
    {
        $sortie = new Sortie();
        $form = $this->createForm(SortieType::class, $sortie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $sortie = $form->getData();
            $db = $doctrine->getManager();

            $var = $db->getRepository(Produit::class)->find($sortie->getProduit()->getId());
            if ( $var->getQte() >= $sortie->getQte()){
                $sortie->setUtilisateur($this->getUser());
                $db->persist($sortie);
                $db->flush();

                $stq = $var->getQte() - $sortie->getQte();
                $var->setQte($stq);
                $db->flush();

            }else{

                $form =$this->createForm(SortieType::class, $sortie);
                $data['form'] = $form->createView();
                $data['listeSortie'] = $doctrine->getRepository(Sortie::class)->findAll();
                $data['error'] = 'Impossible !!! Car la quantité du stock est égale à '.$var->getQte() ;
                return $this->render('sortie/index.html.twig', $data);
            }
        }
        return $this->redirectToRoute('app_sortie');
    }


    #[Route('/updateSor', name: 'app_updateSortie')]
    public function update(PersistenceManagerRegistry $doctrine, Request $request): Response
    {
        $db = $doctrine->getManager();
        $s = $db->getRepository(Sortie::class)->find($_GET['id']);
        $form = $this->createForm(SortieType::class, $s);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $s = $form->getData();
            $s->setUtilisateur($this->getUser());
            $db->persist($s);
            $db->flush();
        }
        return $this->redirectToRoute('app_sortie');
    }
}
