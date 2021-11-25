<?php

namespace App\Form;

use App\Entity\Article;
use App\Form\AuteurType;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre',TextType::class)
            ->add('categorie',EntityType::class, [
                "class" => Categorie::class, 
                "choice_label" => "titre",
            ])
            ->add('auteur',AuteurType::class)
            ->add('contenu',TextareaType::class)
            ->add('resume',TextType::class)
            ->add('image',TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
