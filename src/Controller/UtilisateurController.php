<?php

namespace App\Controller;



use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use App\Form\UtilisateurType;
use phpDocumentor\Reflection\Types\AbstractList;
use SebastianBergmann\CodeCoverage\Report\Html\Renderer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilder;


/**
 * @Route("/utilisateur")
 */

class UtilisateurController extends AbstractController
{

    /**
     * @Route("/", name="utilisateur_index")
     */

    public function index()
    {
        $repo = $this->getDoctrine()
            ->getRepository(Utilisateur::class);
        $utilisateurs = $repo->findAll();


        $vue = "utilisateur/index.html.twig";
        $param = [
            'utilisateurs' => $utilisateurs,
        ];

        return $this->render($vue, $param);
    }

    /**
     * @Route("/new", name="utilisateur_nouveau")
     */

    public function new(Request $request, EntityManagerInterface $manager)
    {
        $u = new Utilisateur();
        $form = $this->createFormBuilder($u)    
            ->add('nom', null, ['label' => "Nom"])
            ->add('prenom', null, ['label' => "Prénom"])
            ->add('login', null, ['label' => "Login"])
            ->add('password', null, ['label' => "Mot de pass"])
            ->add('dateNaissance', DateType::class, ['label' => "Date de naissance"])
            ->add('email', null, ['label' => "E-mail"])
            ->add('adresse', null, ['label' => "Adresse postale"])
            ->add('role', null, ['label' => "Role"])
            ->add('Envoyer', SubmitType::class)

            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($u);
            $manager->flush();

            return $this->redirectToRoute("utilisateur_index");
        }

        $vue = "utilisateur/new.html.twig";
        $param = ["form" => $form->createView()];
        return $this->render($vue, $param);
    }

    /**
     * @Route("/new2", name="utilisateur_nouveau2")
     */

    public function newWithType(Request $request, EntityManagerInterface $manager) : Response
    {
        $u = new Utilisateur(); 
        $form = $this->createForm(UtilisateurType::class,$u);
        $form->handleRequest($request); 
        
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($u); 
            $manager->flush();
            return $this->redirectToRoute("utilisateur_index"); 
        }

        $vue = "utilisateur/new.html.twig"; 
        $param = ["form" => $form->createView()]; 
        return $this->render($vue,$param); 
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
}
