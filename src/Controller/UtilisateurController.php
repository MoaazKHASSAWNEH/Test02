<?php

namespace App\Controller;

use App\Entity\Serch;
use App\Entity\Utilisateur;
use App\Form\SerchType;
use App\Form\UtilisateurType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use phpDocumentor\Reflection\Types\AbstractList;
use Symfony\Component\Security\Core\User\UserInterface;
use SebastianBergmann\CodeCoverage\Report\Html\Renderer;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/utilisateur")
 */

class UtilisateurController extends AbstractController
{

    /**
     * @Route("/", name="utilisateur_index")
     */

    public function index(Request $request)
    {
        $repo = $this->getDoctrine()
            ->getRepository(Utilisateur::class);
        $utilisateurs = $repo->findAll();

        $ser = new Serch(); 
        $serForm = $this->createForm(SerchType::class, $ser);
        $serForm->add("Rechercher",SubmitType::class);
        $serForm->handleRequest($request);

        if ($serForm->isSubmitted() && $serForm->isValid()) {
            // do sumthing
        }

        $vue = "utilisateur/index.html.twig";
        $param = [
            'utilisateurs' => $utilisateurs,
            "ser_form" => $serForm->createView(),        
        ];

        return $this->render($vue, $param);
    }

    /**
     * @Route("/index/{statut}", name="utilisateur_index_statut")
     */

    public function indexStatut(UtilisateurRepository $u, $statut)
    {
        if ($statut == "nonpublie")
            $utilisateurs = $u->findByUtilisateurStatut(1);
        else if ($statut == "archive")
            $utilisateurs = $u->findByUtilisateurStatut(2);
        else 
            return $this->redirectToRoute("utilisateur_index");
        

        return $this->render("Utilisateur/index.html.twig",[
            "utilisateurs" => $utilisateurs,
        ]);
    }

    // /**
    //  * @Route("/new", name="utilisateur_nouveau")
    //  */

    // public function new(Request $request, EntityManagerInterface $manager)
    // {
    //     $u = new Utilisateur();
    //     $form = $this->createFormBuilder($u)    
    //         ->add('nom', null, ['label' => "Nom"])
    //         ->add('prenom', null, ['label' => "Pr??nom"])
    //         ->add('login', null, ['label' => "Login"])
    //         ->add('password', null, ['label' => "Mot de pass"])
    //         ->add('dateNaissance', DateType::class, ['label' => "Date de naissance"])
    //         ->add('email', null, ['label' => "E-mail"])
    //         ->add('adresse', null, ['label' => "Adresse postale"])
    //         ->add('role', null, ['label' => "Role"])
    //         ->add('Envoyer', SubmitType::class)

    //         ->getForm();

    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $manager->persist($u);
    //         $manager->flush();

    //         return $this->redirectToRoute("utilisateur_index");
    //     }

    //     $vue = "utilisateur/new.html.twig";
    //     $param = ["form" => $form->createView()];
    //     return $this->render($vue, $param);
    // }

    /**
     * @Route("/new", name="utilisateur_nouveau2")
     */

    public function newWithType(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder): Response
    {
        $u = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $u);
        if ($connected = $this->getUser()) {
            $rolesConnected = $connected->getRoles();

            if (in_array("ROLE_ADMIN", $rolesConnected) or in_array("ROLE_SUPER_ADMIN", $rolesConnected))
                $form->add("roles", ChoiceType::class, [
                    'choices' => [
                        'Utilisateur' => 'ROLE_USER',
                        'Editeur' => 'ROLE_EDITOR',
                        'Administrateur' => 'ROLE_ADMIN'
                    ],
                    'expanded' => true,
                    'multiple' => true,
                    'label' => 'R??les'
                ]);
        }


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $passwordHashed = $encoder->encodePassword($u, $u->getPassword());
            $u->setPassword($passwordHashed);
            $manager->persist($u);
            $manager->flush();
            return $this->redirectToRoute("utilisateur_index");
        }


        $vue = "utilisateur/new.html.twig";
        $param = [
            "form" => $form->createView(),
            "session" => $connected,
        ];
        return $this->render($vue, $param);
    }

    /**
     * @Route("/{id}", name="utilisateur_id")
     */

    public function affichage(Utilisateur $utilisateur): Response
    {
        $vue = "utilisateur/affichage.html.twig";
        $param = ["utilisateur" => $utilisateur];

        return $this->render($vue, $param);
    }

    /**
     * @Route("/{id}/edit", name="utilisateur_edit")
     */

    public function edit(Request $request, EntityManagerInterface $manager, Utilisateur $u, UserPasswordEncoderInterface $encoder): Response
    {
        $form = $this->createForm(UtilisateurType::class, $u);
        if ($connected = $this->getUser()) {
            $rolesConnected = $connected->getRoles();

            if (in_array("ROLE_ADMIN", $rolesConnected) or in_array("ROLE_SUPER_ADMIN", $rolesConnected))
                $form->add("roles", ChoiceType::class, [
                    'choices' => [
                        'Utilisateur' => 'ROLE_USER',
                        'Editeur' => 'ROLE_EDITOR',
                        'Administrateur' => 'ROLE_ADMIN'
                    ],
                    'expanded' => true,
                    'multiple' => true,
                    'label' => 'R??les'
                ]);
        }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $passwordHashed = $encoder->encodePassword($u, $u->getPassword());
            $u->setPassword($passwordHashed);
            $manager->flush();
            return $this->redirectToRoute("utilisateur_index");
        }

        $vue = "utilisateur/new.html.twig";
        $param = [
            "form" => $form->createView(),
            "session" => $connected,
        ];
        return $this->render($vue, $param);
    }

    /**
     * @Route("/{id}/delete", name="utilisateur_delete")
     */

    public function delete(Request $request, Utilisateur $u, EntityManagerInterface $manager): Response
    {
        $manager->remove($u);
        $manager->flush();

        return $this->redirectToRoute("utilisateur_index");
    }
}
