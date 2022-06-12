<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Entree;
use App\Entity\Produit;
use App\Entity\Role;
use App\Entity\Sortie;
use App\Entity\User;
use App\Form\CategorieType;
use App\Form\EntreeType;
use App\Form\ProduitType;
use App\Form\SortieType;
use App\Form\UserType;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditController extends AbstractController
{
    #[Route('/edit', name: 'app_editProduit')]
    public function index(PersistenceManagerRegistry $doctrine): Response
    {
        $id = $_GET['id'];
        $p = $doctrine->getRepository(Produit::class)->find($id);
        $form = $this->createForm(ProduitType::class, $p , array('action'=>$this->generateUrl('app_updateProduit', ['id'=>$id])));
        $data['form'] = $form->createView();
        return $this->render('edit/index.html.twig', $data);
    }

    #[Route('/editEntree', name: 'app_editEntree')]
    public function editEntree(PersistenceManagerRegistry $doctrine): Response
    {
        $id = $_GET['id'];
        $e = $doctrine->getRepository(Entree::class)->find($id);
        $form = $this->createForm(EntreeType::class, $e , array('action'=>$this->generateUrl('app_updateEntree', ['id'=>$id])));
        $data['form'] = $form->createView();
        return $this->render('edit/index.html.twig', $data);
    }

    #[Route('/editSortie', name: 'app_editSortie')]
    public function editSortie(PersistenceManagerRegistry $doctrine): Response
    {
        $id = $_GET['id'];
        $s = $doctrine->getRepository(Sortie::class)->find($id);
        $form = $this->createForm(SortieType::class, $s , array('action'=>$this->generateUrl('app_updateSortie', ['id'=>$id])));
        $data['form'] = $form->createView();
        return $this->render('edit/index.html.twig', $data);
    }

    #[Route('/editCat', name: 'app_editCategorie')]
    public function editCategorie(PersistenceManagerRegistry $doctrine): Response
    {
        $id = $_GET['id'];
        $s = $doctrine->getRepository(Categorie::class)->find($id);
        $form = $this->createForm(CategorieType::class, $s , array('action'=>$this->generateUrl('app_updateCategorie', ['id'=>$id])));
        $data['form'] = $form->createView();
        $data['listeCategorie'] = $doctrine->getRepository(Categorie::class)->findAll();
        return $this->render('categorie/index.html.twig', $data);
    }

    #[Route('/editUser', name: 'app_editUser')]
    public function editUser(PersistenceManagerRegistry $doctrine): Response
    {
        $id = $_GET['id'];
        $s = $doctrine->getRepository(User::class)->find($id);
        $form = $this->createForm(UserType::class, $s , array('action'=>$this->generateUrl('app_updateUser', ['id'=>$id])));
        $data['form'] = $form->createView();
        $data['roles'] = $doctrine->getRepository(Role::class)->findAll();
        return $this->render('edit/index.html.twig', $data);
    }


}
