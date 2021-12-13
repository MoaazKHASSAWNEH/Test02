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
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\Choice;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add("civilite",ChoiceType::class, [
                "choices" => [
                    "M." => "M.",
                    "Mme" => "Mme",
                ],
                "expanded" => true,
                "multiple" => false,
            ])
            ->add('nom', TextType::class)
            ->add('prenom')
            ->add('photo')
            ->add('dateNaissance', DateType::class)
            ->add('login')
            ->add('password', PasswordType::class, [
                "required" => true,
            ])
            ->add('adresse')
            ->add('email');
        $builder->add('Envoyer', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }

    public function checkRoles(UserInterface $connected)
    {
        if ($connected) {
            $roles = $connected->getRoles();
            if (in_array("ROLE_ADMIN", $roles) or in_array("ROLE_SUPER_ADMIN", $roles))
                return true;
            return false;
        }
        return false;
    }

    public function addForAdmins(UserInterface $connected)
    {
        if ($this->checkRoles($connected))
            $this->builder->add("roles", ChoiceType::class, [
                'choices' => [
                    'Utilisateur' => 'ROLE_USER',
                    'Editeur' => 'ROLE_EDITOR',
                    'Administrateur' => 'ROLE_ADMIN'
                ],
                'expanded' => true,
                'multiple' => true,
                'label' => 'Rôles'
            ]);
    }
}
