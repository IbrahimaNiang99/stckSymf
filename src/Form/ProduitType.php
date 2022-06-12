<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle', TextType::class, array('label'=>'Libellé', 'attr'=>array('class'=>'form-control mb-3', 'placeholder'=>'Le libellé du produit...')))
            ->add('qte', TextType::class, array('label'=>'Quantité', 'attr'=>array('class'=>'form-control mb-3', 'placeholder'=>'Quantité produit...')))
            //->add('utilisateur')
            ->add('categorie', EntityType::class, array('class'=>Categorie::class, 'attr'=>array('class'=>'form-control mb-3')))
            ->add('Ajouter', SubmitType::class, array('label'=>'Ajouter', 'attr'=>array('class'=>'btn btn-success')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
