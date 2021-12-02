<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class)
            ->add('prenom')
            ->add('photo')
            ->add('dateNaissance', DateType::class)
            ->add('login')
            ->add('password', PasswordType::class,[
                "required" => true,
            ])
            ->add('adresse')
            ->add('email')
            ->add("roles",ChoiceType::class,[
                'choices' => [
                  'Utilisateur' => 'ROLE_USER',
                  'Editeur' => 'ROLE_EDITOR',
                  'Administrateur' => 'ROLE_ADMIN'
              ],
              'expanded' => true,
              'multiple' => true,
              'label' => 'Rôles'
          ])
            ->add('Envoyer', SubmitType::class)
        ;
        
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
