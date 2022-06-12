<?php

namespace App\Form;

use App\Entity\Role;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom', TextType::class, array('label'=>'Prénom', 'attr'=>array('class'=>'form-control mb-3', 'placeholder'=>"le prénom de l'utilisateur ...")))
            ->add('nom', TextType::class, array('label'=>'Nom', 'attr'=>array('class'=>'form-control mb-3', 'placeholder'=>"Le nom de l'utilisateur ...")))
            ->add('email', TextType::class, array('label'=>'Adresse email', 'attr'=>array('class'=>'form-control mb-3', 'placeholder'=>'email ...')))
            ->add('password', TextType::class, array('label'=>'Mot de passe par défaut', 'attr'=>array('class'=>'form-control mb-3', 'value'=>'passer', 'disabled'=>'disabled')))
            ->add('roles')
            //->add('utilisateur')

            ->add('Ajouter', SubmitType::class, array('label'=>'Ajouter', 'attr'=>array('class'=>'form-control btn btn-success')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
