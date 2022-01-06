<?php

namespace App\Form;

use App\Entity\Auteur;
use App\Entity\Article;
use App\Form\AuteurType;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
            ->add('auteur',EntityType::class,[
                "class" => Auteur::class,
                "choice_label" => function (Auteur $a) {
                    return $a->getNom() . " " . $a->getPrenom();
                },
                "expanded" => true,
            ])
            ->add('contenu',
                CKEditorType::class, [
                    "label" => "Contenu",
                    "attr" => [
                        "placeholder" => "Contenu de l'article",
                    ],
                ]
            )
            ->add('resume',TextType::class)
            ->add('image',TextType::class)
            ->add('imageFile', VichImageType::class, [
                'label' => 'Image à inserrer',
                'required' => false,
            ])
            ->add("Envoyer",SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
