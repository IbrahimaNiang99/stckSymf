<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Sortie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateSortie')
            ->add('qte',IntegerType::class, array('label'=>'Quantité', 'attr'=>array('class'=>'form-control mb-3', 'placeholder'=>'La quantité ...', 'min'=>1)))
            ->add('prix',IntegerType::class, array('label'=>'Prix', 'attr'=>array('class'=>'form-control mb-3', 'placeholder'=>'Le prix du produit ...', 'min'=>1)))
            //->add('utilisateur')
            ->add('produit', EntityType::class,  array('class'=>Produit::class, 'attr'=>array('class'=>'form-control mb-3', 'placeholder'=>'La quantité ...', 'min'=>1)))
            ->add('Ajouter', SubmitType::class,  array('label'=>'Ajouter', 'attr'=>array('class'=>'btn btn-success mb-2', 'placeholder'=>'La quantité ...', 'min'=>1)))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
